<?php

namespace App\Services;

use App\Models\AssetLogs;
use App\Models\AssetRequest;
use App\Models\Assets;
use App\Models\SystemSettings;
use App\Models\TechnicalSpecification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vendors;
use App\Services\NotificationService;

class AssetService
{
    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function getActiveUsers()
    {
        return User::where('status', 'active')->get();
    }

    public function getActiveVendors()
    {
        return Vendors::where('status', 'Active')->get();
    }

    public function getAssetArchive()
    {
        return Assets::where('operational_status', 'archived')->latest()->get();
    }

    public function getAssetLogs($id)
    {
        return AssetLogs::where('asset_id', $id)->with(['asset', 'user'])->latest()->get();
    }

    public function getAssetByTag(string $assetTag): Assets
    {
        return Assets::with(['technicalSpecifications', 'users', 'vendor'])
            ->where('asset_tag', $assetTag)
            ->firstOrFail();
    }

    public function getAllAssetsWithDepreciation()
    {
        $assets = Assets::where('operational_status', '!=', 'archived')->latest('updated_at')->get();

        return $assets->map(function ($asset) {
            if ($asset->asset_type === 'Digital Asset') {
                $asset->depreciation_expense = 0;
                $asset->current_value =  0;
                $asset->years_used = 0;
                $asset->remaining_life = $asset->useful_life_years ?? 0;
                $asset->depreciation_rate = 0;
                return $asset;
            }

            $cost = $asset->purchase_cost ?? 0;
            $salvage = $asset->salvage_value ?? 0;
            $usefulLife = $asset->useful_life_years ?? 1;

            $yearsUsed = $asset->purchase_date->diffInYears(now());
            $depreciation = ($cost - $salvage) / $usefulLife;
            $totalDepreciation = $depreciation * $yearsUsed;
            $currentValue = max($cost - $totalDepreciation, $salvage);

            $asset->depreciation_expense = $depreciation;
            $asset->current_value = $currentValue;
            $asset->years_used = $yearsUsed;
            $asset->remaining_life = max($usefulLife - $yearsUsed, 0);
            $asset->depreciation_rate = (($cost - $salvage) / $cost / $usefulLife) * 100;
            return $asset;
        });
    }

    public function getIndexData(): array
    {
        return [
            'items'   => $this->getAllAssetsWithDepreciation(),
            'users'   => $this->getActiveUsers(),
            'vendors' => $this->getActiveVendors(),
        ];
    }

    public function getShowData(string $assetTag): array
    {
        $asset = $this->getAssetByTag($assetTag);

        return [
            'item'      => $asset,
            'users'     => $this->getActiveUsers(),
            'vendors'   => $this->getActiveVendors(),
            'AssetLogs' => $this->getAssetLogs($asset->id),
        ];
    }

    public function store(array $data): Assets
    {

        $data['created_by'] = Auth::id();
        $data['asset_tag'] = $this->generateAssetTag($data['asset_type']);
        $data['asset_id'] = $this->generateAssetId();

        // if (($data['asset_type'] ?? null) === 'Physical Asset' && empty($data['assigned_to'])) {
        //     $data['location'] = 'Warehouse';
        // }

        if (($data['asset_type'] ?? null) === 'Physical Asset' && empty($data['assigned_to'])) {
            $data['location'] = $data['location'] ?? 'Warehouse';
        }
        $asset = Assets::create($data);


        if (!empty($data['specs'])) {
            foreach ($data['specs'] as $key => $value) {
                if ($value !== null && $value !== '') {
                    TechnicalSpecification::create([
                        'asset_id'   => $asset->id,
                        'spec_key'   => $key,
                        'spec_value' => $value,
                    ]);
                }
            }
        }


        if (!empty($data['AssetRequestId'])) {
            AssetRequest::where('id', $data['AssetRequestId'])->update(['is_added' => 1]);
        }

        $this->notification->notifyUsersWithModuleAccess(
            'Assets',
            'read',
            'Asset Created',
            "Asset #" . $asset->asset_tag . " has been created by: " . Auth::user()->name . ".",
            'info'
        );

        $this->logAssetChange($asset, 'Created: ', $asset->asset_tag, null,  $asset->asset_name);
        return $asset;
    }

    public function updateAsset(Assets $asset, array $data): Assets
    {
        $original = $asset->getOriginal();

        if (isset($data['technical'])) {
            foreach ($data['technical'] as $specId => $value) {
                $spec = $asset->technicalSpecifications()->find($specId);

                if ($spec && $spec->spec_value != $value) {
                    $this->logAssetChange($asset, 'changed', 'Technical spec: ' . $spec->spec_key, $spec->spec_value, $value);
                    $spec->update(['spec_value' => $value]);
                }
            }
            unset($data['technical']);
        }


        foreach ($data as $field => $newValue) {
            if (
                array_key_exists($field, $original) &&
                $original[$field] != $newValue
            ) {
                $this->logAssetChange($asset, 'changed ', $field, $original[$field], $newValue);
            }
        }


        $this->notification->notifyUsersWithModuleAccess(
            'Assets',
            'read',
            'Asset Updated',
            "Asset #" . $asset->asset_tag . " has been updated by: " . Auth::user()->name . ".",
            'info'
        );

        $asset->update($data);
        return $asset;
    }

    private function generateAssetTag($type): string
    {
        $setting = SystemSettings::first();

        if ($type === 'Digital Asset') {
            $Prefix = $setting->digital_tag_prefix ?? 'DG';
        } else {
            $Prefix = $setting->physical_tag_prefix  ?? 'PH';
        }

        do {
            $tag = $Prefix . '-' . strtoupper(Str::random(4));
        } while (Assets::where('asset_tag', $tag)->exists());

        return $tag;
    }

    private function generateAssetId(): string
    {
        do {
            $part1 = strtoupper(Str::random(4));
            $part2 = strtoupper(Str::random(4));
            $part3 = strtoupper(Str::random(2));

            $assetId = $part1 . '-' . $part2 . '-' . $part3;
        } while (Assets::where('asset_id', $assetId)->exists());

        return $assetId;
    }

    public function deleteAsset(int $id, array $data)
    {
        $asset = Assets::findOrFail($id);
        $asset->operational_status = 'archived';
        $asset->delete_title = $data['delete_title'];
        $asset->delete_reason = $data['delete_reason'];

        $this->notification->notifyUsersWithModuleAccess(
            'Assets',
            'read',
            'Asset Deleted',
            "Asset #" . $asset->asset_tag . " has been deleted by: " . Auth::user()->name . ".",
            'warning'
        );

        $asset->save();

        return $asset;
    }

    protected function logAssetChange(Assets $asset, string $action, ?string $field, $old, $new)
    {
        AssetLogs::create([
            'asset_id'  => $asset->id,
            'user_id'   => Auth::id(),
            'action'    => $action,
            'field_name' => $field,
            'old_value' => is_array($old) ? json_encode($old) : $old,
            'new_value' => is_array($new) ? json_encode($new) : $new,
        ]);
    }
}
