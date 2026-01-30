<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\TechnicalSpecification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

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

    public function getAssetArchive()
    {
        return Assets::where('operational_status', 'archived')->get();
    }

    public function store(array $data): Assets
    {
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
