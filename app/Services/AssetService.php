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
        $assets = Assets::get();

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

    public function store(array $data): Assets
    {
        return DB::transaction(function () use ($data) {

            $asset = Assets::create([
                'created_by'         => Auth::id(),
                'asset_tag'          => $this->generateAssetTag(),
                'asset_id'           => $this->generateAssetId(),
                'asset_name'         => $data['asset_name'],
                'asset_category'     => $data['asset_category'],
                'asset_type'         => $data['asset_type'],
                'operational_status' => $data['operational_status'] ?? null,
                'assigned_to'        => $data['assigned_to'] ?? null,
                'department'         => $data['department'] ?? null,
                'location'           => $data['location'] ?? null,
                'vendor'             => $data['vendor'] ?? null,
                'purchase_date'      => $data['purchase_date'] ?? null,
                'purchase_cost'      => $data['purchase_cost'] ?? null,
                'useful_life_years'  => $data['useful_life_years'] ?? null,
                'salvage_value'      => $data['salvage_value'] ?? null,
                'compliance_status'  => $data['compliance_status'] ?? null,
                'warranty_start'     => $data['warranty_start'] ?? null,
                'warranty_end'       => $data['warranty_end'] ?? null,
                'next_maintenance'   => $data['next_maintenance'] ?? null,
            ]);


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
        });
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
}
