<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\User;
use App\Models\AssetCategory;

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

    protected function calculateDepreciation($asset)
    {
        $cost = (float) ($asset->purchase_cost ?? 0);
        $salvage = (float) ($asset->salvage_value ?? 0);
        $usefulLife = (int) ($asset->useful_life_years ?? 1);
        $purchaseDate = $asset->purchase_date;

        $yearsUsed = $purchaseDate ? $purchaseDate->diffInYears(now()) : 0;

        // Defaults
        $depreciationPerYear = 0;
        $depreciationRate = 0;
        $totalDepreciation = 0;
        $currentValue = $cost;
        $remainingLife = $usefulLife;

        // Calculate depreciation only for physical assets
        if ($asset->asset_type !== 'Digital Asset' && $cost > 0 && $usefulLife > 0) {
            $depreciationPerYear = ($cost - $salvage) / $usefulLife;
            $depreciationRate = (($cost - $salvage) / $cost / $usefulLife) * 100;
            $totalDepreciation = $depreciationPerYear * $yearsUsed;
            $currentValue = max($cost - $totalDepreciation, $salvage);
            $remainingLife = max($usefulLife - $yearsUsed, 0);
        } else {
            $currentValue = 0;
            $yearsUsed = 0;
            $remainingLife = $usefulLife;
        }

        $asset->depreciation_expense = $depreciationPerYear;
        $asset->depreciation_rate = $depreciationRate;
        $asset->current_value = $currentValue;
        $asset->years_used = $yearsUsed;
        $asset->remaining_life = $remainingLife;

        return $asset;
    }

    public function getPhysicalDepreciationSum()
    {
        $assets = $this->getTotalPhysical();

        $assetsWithDepreciation = $assets->map(fn($asset) => $this->calculateDepreciation($asset));

        return $assetsWithDepreciation->sum('current_value');
    }

    public function getDigitalDepreciationSum()
    {
        $assets = $this->getTotalDigital();

        $assetsWithDepreciation = $assets->map(fn($asset) => $this->calculateDepreciation($asset));

        return $assetsWithDepreciation->sum('current_value');
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
            'categories' => $this->getAssetCategory(),
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

    public function getAssetCategory()
    {
        return AssetCategory::latest()->get();
    }

    public function getComplianceStatuses()
    {
        return Assets::where('operational_status',  '!=', 'archived')->selectRaw('warranty_status, COUNT(*) as total')
            ->groupBy('warranty_status')
            ->pluck('total', 'warranty_status')
            ->toArray();
    }

    public function getAllAssetsWithDepreciation($limit = 10)
    {
        $assets = Assets::with([
            'users',
            'vendor',
            'documents',
            'maintenances.logs'
        ])
            ->where('operational_status', '!=', 'archived')
            ->latest('updated_at')
            ->take($limit)
            ->get();

        $assetsWithDepreciation = $assets->map(function ($asset) {

            $cost = (float) ($asset->purchase_cost ?? 0);
            $salvage = (float) ($asset->salvage_value ?? 0);
            $usefulLife = (int) ($asset->useful_life_years ?? 1);
            $purchaseDate = $asset->purchase_date;

            $yearsUsed = $purchaseDate ? $purchaseDate->diffInYears(now()) : 0;

            // Defaults
            $depreciationPerYear = 0;
            $depreciationRate = 0;
            $totalDepreciation = 0;
            $currentValue = $cost;
            $remainingLife = $usefulLife;
            $totalMaintenanceCost = 0;
            $annualDepreciation = 0;

            // Skip digital assets
            if ($asset->asset_type === 'Digital Asset') {
                $asset->depreciation_per_year = 0;
                $asset->depreciation_rate = 0;
                $asset->total_depreciation = 0;
                $asset->current_value = 0;
                $asset->years_used = 0;
                $asset->remaining_life = $usefulLife;
                $asset->total_maintenance_cost = 0;
                $asset->annual_depreciation = 0;
                return $asset;
            }

            // Calculate depreciation if valid
            if ($cost > 0 && $usefulLife > 0) {
                $depreciationPerYear = ($cost - $salvage) / $usefulLife;
                $depreciationRate = (($cost - $salvage) / $cost / $usefulLife) * 100;
                $totalDepreciation = $depreciationPerYear * $yearsUsed;
                $currentValue = max($cost - $totalDepreciation, $salvage);
                $remainingLife = max($usefulLife - $yearsUsed, 0);
            }

            // Sum all maintenance costs
            if ($asset->maintenances && $asset->maintenances->count() > 0) {
                foreach ($asset->maintenances as $maintenance) {
                    if ($maintenance->logs && $maintenance->logs->count() > 0) {
                        $totalMaintenanceCost += $maintenance->logs->sum(fn($log) => $log->cost ?? 0);
                    }
                }
            }

            // Annual depreciation including maintenance
            $annualDepreciation = $remainingLife > 0
                ? ($currentValue + $totalMaintenanceCost) / $remainingLife
                : 0;

            // Attach calculated fields
            $asset->depreciation_per_year = $depreciationPerYear;
            $asset->depreciation_rate = $depreciationRate;
            $asset->total_depreciation = $totalDepreciation;
            $asset->current_value = $currentValue;
            $asset->years_used = $yearsUsed;
            $asset->remaining_life = $remainingLife;
            $asset->total_maintenance_cost = $totalMaintenanceCost;
            $asset->annual_depreciation = $annualDepreciation;

            return $asset;
        });

        return $assetsWithDepreciation;
    }
}
