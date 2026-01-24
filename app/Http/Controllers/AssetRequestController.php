<?php

namespace App\Http\Controllers;

use App\Services\AssetRequestService;
use App\Http\Requests\AssetRequest\StoreAssetRequest;
use App\Http\Requests\AssetRequest\UpdateAssetRequestStatus;
use App\Models\AssetRequest;
use Illuminate\Http\Request;

class AssetRequestController extends Controller
{
    protected AssetRequestService $assetRequestService;

    public function __construct(AssetRequestService $assetRequestService)
    {
        $this->assetRequestService = $assetRequestService;
    }

    public function index()
    {
        $items = AssetRequest::get();

        $TotalProcured = AssetRequest::where('status', 'Procured')->count();
        $TotalRequests = AssetRequest::where('status', '!=', 'Procured')->count();
        $TotalEmergency = AssetRequest::where('priority', 'Emergency')->count();

        return view('Pages/assetRequest', compact('items', 'TotalProcured', 'TotalRequests', 'TotalEmergency'));
    }

    public function store(StoreAssetRequest $request)
    {
        try {
            $this->assetRequestService->store($request->validated());

            return redirect()->back()->with('success', 'Asset Request created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function updateStatus(UpdateAssetRequestStatus $request, AssetRequest $assetRequest)
    {
        try {
            $this->assetRequestService->updateStatus($assetRequest, $request->only(['status', 'remarks']));

            return redirect()->back()->with('success', 'Asset request status updated.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function approveStatus(Request $request, AssetRequest $assetRequest)
    {
        try {
            $this->assetRequestService->updateApproval($assetRequest, [
                'is_approved' => 'approved',
                'remarks'     => $request->remarks,
            ]);

            return redirect()->back()->with('success', 'Asset request approved.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function rejectStatus(Request $request, AssetRequest $assetRequest)
    {
        try {
            $this->assetRequestService->updateApproval($assetRequest, [
                'is_approved' => 'rejected',
                'remarks'     => $request->remarks,
            ]);

            return redirect()->back()->with('success', 'Asset request rejected.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
