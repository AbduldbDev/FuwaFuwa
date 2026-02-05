<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\AssetRequest;
use App\Models\User;
use App\Models\Vendors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\NotificationService;

class AssetRequestService
{
    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function getAllRequests()
    {
        return AssetRequest::latest('updated_at')->get();
    }

    public function getTotalProcured()
    {
        return AssetRequest::where('status', 'Procured')->count();
    }

    public function getTotalPendingRequests()
    {
        return AssetRequest::whereNotIn('status', ['Procured', 'Rejected'])->count();
    }

    public function TotalOnHandPhysical()
    {
        return Assets::whereNull('assigned_to')->where('asset_type', 'Physical Asset')->count();
    }

    public function TotalOnHandDigital()
    {
        return Assets::whereNull('assigned_to')->where('asset_type', 'Digital Asset')->count();
    }

    public function getActiveUsers()
    {
        return User::where('status', 'active')->get();
    }

    public function getActiveVendors()
    {
        return Vendors::where('status', 'Active')->get();
    }

    public function getRequestStatusCounts()
    {
        return AssetRequest::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }


    public function getDashboardData()
    {
        return [
            'items' => $this->getAllRequests(),
            'TotalProcured' => $this->getTotalProcured(),
            'TotalRequests' => $this->getTotalPendingRequests(),
            'TotalOnHandDigital' => $this->TotalOnHandDigital(),
            'TotalOnHandPhysical' => $this->TotalOnHandPhysical(),
            'users' => $this->getActiveUsers(),
            'vendors' => $this->getActiveVendors(),
            'RequestStatusCounts' => $this->getRequestStatusCounts(),
        ];
    }

    public function store(array $data): AssetRequest
    {
        $data['request_id'] = $this->generateRequestId();
        $data['user_id'] = Auth::id();
        $assetRequest =  AssetRequest::create($data);

        $this->notification->notifyUsersWithModuleAccess(
            'Asset Request',
            'read',
            'New Asset Request',
            "New " . $assetRequest->priority . " priority asset request #" . $assetRequest->request_id . " has been submitted by " . Auth::user()->name . ".",
            'info'
        );

        return $assetRequest;
    }


    public function forreview(AssetRequest $request, array $data): AssetRequest
    {
        $status = (isset($data['status']) && $data['status'] === 'available')
            ? 'For Release'
            : 'In Progress';

        $request->update([
            'status' => $status,
        ]);

        return $request;
    }


    public function updateStatus(AssetRequest $request, array $data): AssetRequest
    {
        $request->update([
            'status'  => $data['status'],
            'remarks' => $data['remarks'] ?? $request->remarks,
        ]);

        $this->notification->notifyUsersWithModuleAccess(
            'Asset Request',
            'read',
            'Asset Request Status Updated',
            "Asset request #{$request->request_id} status was updated to " . $request->status . " by " . Auth::user()->name . ".",
            'info'
        );
        return $request;
    }

    public function updateApproval(AssetRequest $assetRequest, array $data): AssetRequest
    {
        $approvalStatus = $data['is_approved'];
        $newStatus = $approvalStatus === 'approved' ? 'For Procurement' : 'Closed';

        $assetRequest->update([
            'is_approved' => $approvalStatus,
            'remarks'     => $data['remarks'] ?? $assetRequest->remarks,
            'status'      => $newStatus,
        ]);

        $this->notification->notifyUsersWithModuleAccess(
            'Asset Request',
            'read',
            'Asset Request ' . ucfirst($approvalStatus),
            "Asset request #{$assetRequest->request_id} status was " . $approvalStatus . " by " . Auth::user()->name . ".",
            'info'
        );
        return $assetRequest;
    }

    private function generateRequestId(): string
    {
        $year = Carbon::now()->year;
        $lastRequest = AssetRequest::whereYear('created_at', $year)
            ->where('request_id', 'like', "PR-$year-%")
            ->orderBy('request_id', 'desc')
            ->first();

        $lastNumber = $lastRequest
            ? (int) substr($lastRequest->request_id, -3)
            : 0;

        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        return "PR-$year-$nextNumber";
    }
}
