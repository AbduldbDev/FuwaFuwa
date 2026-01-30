<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\TechnicalSpecification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vendors;

class AssetService
{
    public function getAllAssetsWithDepreciation()
    {
        $assets = Assets::where('operational_status',  '!=', 'archived')->get();

        return $assets->map(function ($asset) {
            $cost = $asset->purchase_cost ?? 0;
            $salvage = $asset->salvage_value ?? 0;
            $usefulLife = $asset->useful_life_years ?? 1;

            $depreciation = ($cost - $salvage) / $usefulLife;
            $currentValue = $cost - $depreciation;

            $asset->depreciation_expense = $depreciation;
            $asset->current_value = $currentValue;

            return $asset;
        });
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
        return Assets::where('operational_status', 'archived')->get();
    }

    public function store(array $data): Assets
    {
        foreach (['contract', 'purchase_order'] as $fileField) {
            if (!empty($data[$fileField])) {
                $file = $data[$fileField];
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $originalName . '_' . time() . '.' . $extension;
                $path = $file->storeAs('AssetDocuments', $filename, 'public');

                // Save path in data
                $data[$fileField] = '/storage/' . $path;
            }
        }


        $data['created_by'] = Auth::id();
        $data['asset_tag'] = $this->generateAssetTag();
        $data['asset_id'] = $this->generateAssetId();
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

        return $asset;
    }

    public function updateAsset(Assets $asset, array $data): Assets
    {

        if (isset($data['technical'])) {
            foreach ($data['technical'] as $specId => $value) {
                $spec = $asset->technicalSpecifications()->find($specId);
                if ($spec) {
                    $spec->update(['spec_value' => $value]);
                }
            }
            unset($data['technical']);
        }

        foreach (['contract', 'purchase_order'] as $fileField) {
            if (!empty($data[$fileField]) && $data[$fileField] instanceof \Illuminate\Http\UploadedFile) {
                if ($asset->{$fileField}) {
                    Storage::delete(str_replace('/storage/', '', $asset->{$fileField}));
                }

                $file = $data[$fileField];
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $originalName . '_' . time() . '.' . $extension;

                $path = $file->storeAs('AssetDocuments', $filename, 'public');
                $data[$fileField] = '/storage/' . $path;
            }
        }
        $asset->update($data);

        return $asset;
    }

    private function generateAssetTag(): string
    {
        do {
            $tag = 'Asset' . strtoupper(Str::random(4));
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


    public function deleteAsset(int $id)
    {
        $asset = Assets::findOrFail($id);
        $asset->operational_status = 'archived';
        $asset->save();

        return $asset;
    }
}
