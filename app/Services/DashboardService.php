<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\User;

class DashboardService
{
    public function getLatestAssets($limit = 10)
    {
        return Assets::where('operational_status',  '!=', 'archived')->orderBy('created_at', 'desc')->take($limit)->get();
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
        return Assets::where('status', 'active')
            ->get()
            ->sum(function ($asset) {
                $cost = $asset->purchase_cost ?? 0;
                $salvage = $asset->salvage_value ?? 0;
                $totalUnits = $asset->useful_life_years ?? 1;

                return ($cost - $salvage) / $totalUnits;
            });
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
            'items' => $this->getLatestAssets(),
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
