<?php

namespace App\Services;

use App\Models\AssetCategory;
use App\Models\Assets;
use App\Models\AssetRequest;
use App\Models\User;
use App\Models\Vendors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\NotificationService;

class AssetCategoryService
{
    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function getCategories()
    {
        return AssetCategory::with(['user'])->latest('updated_at')->get();
    }

    public function create(array $data)
    {
        $data['requested_by'] = Auth::user()->id;
        $assetCategory = AssetCategory::create($data);

        $this->notification->notifyUsersWithModuleAccess(
            'Asset Category',
            'write',
            'Category Created',
            "Asset Category {$assetCategory->name} has been created by: " . Auth::user()->name,
            'info'
        );

        return $assetCategory;
    }

    public function update($id, array $data)
    {
        $assetCategory = AssetCategory::findOrFail($id);
        $assetCategory->update($data);

        $this->notification->notifyUsersWithModuleAccess(
            'Asset Category',
            'write',
            'Category Updated',
            "Asset Category {$assetCategory->name} has been updated by: " . Auth::user()->name,
            'info'
        );

        return $assetCategory;
    }
}
