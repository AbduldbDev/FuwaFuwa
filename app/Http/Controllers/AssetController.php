<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Assets\StoreAssets;
use App\Models\Assets;
use App\Models\User;
use App\Services\AssetService;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    protected AssetService $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function index()
    {
        if (!user()->canAccess('Assets', 'read')) {
            abort(403, 'Unauthorized');
        }

        $items = $this->assetService->getAllAssetsWithDepreciation();
        $users = $this->assetService->getActiveUsers();

        return view('Pages.assets', compact('items', 'users'));
    }

    public function show($id)
    {
        if (!user()->canAccess('Assets', 'read')) {
            abort(403, 'Unauthorized');
        }

        $item = Assets::with(['technicalSpecifications', 'users'])->where('asset_tag', $id)->first();
        $users = $this->assetService->getActiveUsers();
        return view('Pages/assetDetails', compact('item', 'users'));
    }

    public function store(StoreAssets $request)
    {
        if (!user()->canAccess('Assets', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->assetService->store($request->validated());

            return redirect()->back()->with('success', 'Asset created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
