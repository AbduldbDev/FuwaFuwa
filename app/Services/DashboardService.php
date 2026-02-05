<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\User;

class DashboardService
{

    public function getTotalPhysical()
    {
        return Assets::where('operational_status', '!=', 'archived')->where('asset_type', 'Physical Asset')->get();
    }

    public function getTotalDigital()
    {
        return Assets::where('operational_status', '!=', 'archived')->where('asset_type', 'Digital Asset')->get();
    }

    public function getPhysicalDepreciationSum()
    {
        $assets = $this->getTotalPhysical();

        $assetsWithDepreciation = $assets->map(function ($asset) {

            if ($asset->asset_type === 'Digital Asset') {
                $asset->depreciation_expense = 0;
                $asset->current_value = 0;
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


        $totalAssetValue = $assetsWithDepreciation->sum('current_value');
        return $totalAssetValue;
    }

    public function getDigitalDepreciationSum()
    {
        $assets = $this->getTotalDigital();

        $assetsWithDepreciation = $assets->map(function ($asset) {

            if ($asset->asset_type === 'Digital Asset') {
                $asset->depreciation_expense = 0;
                $asset->current_value = 0;
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


        $totalAssetValue = $assetsWithDepreciation->sum('current_value');
        return $totalAssetValue;
    }


    public function getDashboardData()
    {
        return [
            'items' => $this->getAllAssetsWithDepreciation(),
            'TotalPhysicalDepreciationSum' => $this->getPhysicalDepreciationSum(),
            'TotalDigitalDepreciationSum' => $this->getDigitalDepreciationSum(),

            'TotalCostDigital' => $this->getTotalCostDigital(),
            'TotalCostPhysical' => $this->getTotalCostPhysical(),
            'TotalCost' => $this->getTotalCost(),
            'TotalInStockDigital' =>  $this->getTotalInStockDigital(),
            'TotalInStockPhysical' =>  $this->getTotalInStockPhysical(),
            'TotalInStock' =>  $this->getTotalInStock(),
            'TotalPhysicalAsset' =>  $this->getTotalPhysicalAssets(),
            'TotalDigitalAsset' =>  $this->getTotalDigitalAssets(),
            'TotalAssets' =>  $this->getTotalAssets(),
            'ComplianceStatuses' => $this->getComplianceStatuses(),
            'usersByType' => $this->getUsersByType(),
            'AssetCategories' => $this->getAssetCategories(),
        ];
    }

    public function getAssetCategories()
    {
        return Assets::where('operational_status',  '!=', 'archived')->selectRaw('asset_category, COUNT(*) as total')
            ->groupBy('asset_category')
            ->pluck('total', 'asset_category')
            ->toArray();
    }


    public function getTotalCost()
    {
        return Assets::where('operational_status',  '!=', 'archived')->sum('purchase_cost');
    }

    public function getTotalCostPhysical()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('asset_type', 'Physical Asset')->sum('purchase_cost');
    }

    public function getTotalCostDigital()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('asset_type', 'Digital Asset')->sum('purchase_cost');
    }

    public function getTotalInStockDigital()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('assigned_to', null)->where('asset_type', 'Digital Asset')->count();
    }

    public function getTotalInStockPhysical()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('assigned_to', null)->where('asset_type', 'Physical Asset')->count();
    }

    public function getTotalInStock()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('assigned_to', null)->count();
    }

    public function getUsersByType()
    {
        return User::selectRaw('user_type, COUNT(*) as total')
            ->groupBy('user_type')
            ->pluck('total', 'user_type')
            ->toArray();
    }

    public function getTotalAssets()
    {
        return Assets::where('operational_status',  '!=', 'archived')->count();
    }

    public function  getTotalPhysicalAssets()
    {

        return Assets::where('operational_status',  '!=', 'archived')->where('asset_type', 'Physical Asset')->count();
    }

    public function  getTotalDigitalAssets()
    {
        return Assets::where('operational_status',  '!=', 'archived')->where('asset_type', 'Digital Asset')->count();
    }

    public function getComplianceStatuses()
    {
        return Assets::where('operational_status',  '!=', 'archived')->selectRaw('compliance_status, COUNT(*) as total')
            ->groupBy('compliance_status')
            ->pluck('total', 'compliance_status')
            ->toArray();
    }

    public function getAllAssetsWithDepreciation($limit = 10)
    {
        $assets = Assets::where('operational_status', '!=', 'archived')->latest('updated_at')->take($limit)->get();

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
}
