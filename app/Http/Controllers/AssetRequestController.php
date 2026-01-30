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
        if (!user()->canAccess('Asset Request', 'read')) {
            abort(403, 'Unauthorized');
        }

        $data = $this->assetRequestService->getDashboardData();

        return view('Pages/assetRequest', $data);
    }

    public function store(StoreAssetRequest $request)
    {
        if (!user()->canAccess('Asset Request', 'write')) {
            abort(403, 'Unauthorized');
        }

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
        if (!user()->canAccess('Asset Request', 'write')) {
            abort(403, 'Unauthorized');
        }

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
        if (!user()->canAccess('Asset Request', 'write')) {
            abort(403, 'Unauthorized');
        }

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
        if (!user()->canAccess('Asset Request', 'write')) {
            abort(403, 'Unauthorized');
        }

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
