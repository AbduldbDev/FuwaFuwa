<?php

namespace App\Services;

use App\Models\Assets;
use App\Models\AssetRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AssetRequestService
{

    public function getAllRequests()
    {
        return AssetRequest::get();
    }

    public function getTotalProcured()
    {
        return AssetRequest::where('status', 'Procured')->count();
    }

    public function getTotalPendingRequests()
    {
        return AssetRequest::whereNotIn('status', ['Procured', 'Rejected'])->count();
    }

    public function getTotalEmergency()
    {
        return AssetRequest::where('priority', 'Emergency')->count();
    }

    public function getTotalOnHand()
    {
        return Assets::where('assigned_to', null)->count();
    }

    public function getDashboardData()
    {
        return [
            'items' => $this->getAllRequests(),
            'TotalProcured' => $this->getTotalProcured(),
            'TotalRequests' => $this->getTotalPendingRequests(),
            'TotalEmergency' => $this->getTotalEmergency(),
            'TotalOnHand' => $this->getTotalOnHand(),
        ];
    }

    public function store(array $data): AssetRequest
    {
        $data['request_id'] = $this->generateRequestId();
        $data['user_id'] = Auth::id();
        $assetRequest =  AssetRequest::create($data);

        return $assetRequest;
    }

    public function updateStatus(AssetRequest $request, array $data): AssetRequest
    {
        $request->update([
            'status'  => $data['status'],
            'remarks' => $data['remarks'] ?? $request->remarks,
        ]);

        return $request;
    }

    public function updateApproval(AssetRequest $assetRequest, array $data): AssetRequest
    {
        $approvalStatus = $data['is_approved'];
        $newStatus = $approvalStatus === 'approved' ? 'In Procurement' : 'Rejected';

        $assetRequest->update([
            'is_approved' => $approvalStatus,
            'remarks'     => $data['remarks'] ?? $assetRequest->remarks,
            'status'      => $newStatus,
        ]);

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
