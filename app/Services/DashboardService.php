<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\User;

class DashboardService
{
    public function getAllAssetsWithDepreciation($limit = 10)
    {
        $assets = Assets::where('operational_status', '!=', 'archived')->latest()->take($limit)->get();

        return $assets->map(function ($asset) {
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

    public function getTotalAssets()
    {
        return Assets::where('operational_status',  '!=', 'archived')->count();
    }

    public function getTotalOnHand()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('assigned_to', null)->count();
    }

    public function getTotalCost()
    {
        return Assets::where('operational_status',  '!=', 'archived')->sum('purchase_cost');
    }

    public function getDepreciationSum()
    {
        $assets = Assets::where('operational_status', '!=', 'archived')->get();

        $assetsWithDepreciation = $assets->map(function ($asset) {
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

        $totalAssetValue = $assetsWithDepreciation->sum('current_value');
        return $totalAssetValue;
    }

    public function getAssetCategories()
    {
        return Assets::where('operational_status',  '!=', 'archived')->selectRaw('asset_category, COUNT(*) as total')
            ->groupBy('asset_category')
            ->pluck('total', 'asset_category')
            ->toArray();
    }

    public function getComplianceStatuses()
    {
        return Assets::where('operational_status',  '!=', 'archived')->selectRaw('compliance_status, COUNT(*) as total')
            ->groupBy('compliance_status')
            ->pluck('total', 'compliance_status')
            ->toArray();
    }

    public function getUsersByType()
    {
        return User::selectRaw('user_type, COUNT(*) as total')
            ->groupBy('user_type')
            ->pluck('total', 'user_type')
            ->toArray();
    }

    public function getDashboardData()
    {
        return [
            'items' => $this->getAllAssetsWithDepreciation(),
            'totalAssets' => $this->getTotalAssets(),
            'totalonhand' => $this->getTotalOnHand(),
            'totalCost' => $this->getTotalCost(),
            'depreciationSum' => $this->getDepreciationSum(),
            'assetCategories' => $this->getAssetCategories(),
            'complianceStatuses' => $this->getComplianceStatuses(),
            'usersByType' => $this->getUsersByType(),
        ];
    }
}
