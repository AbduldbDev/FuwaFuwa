<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Assets\StoreAssets;
use App\Models\Assets;
use App\Services\AssetService;


class AssetController extends Controller
{
    protected AssetService $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function index()
    {
        $items = Assets::get();
        return view('Pages/assets', compact('items'));
    }

    public function show($id)
    {
        $item = Assets::with(['technicalSpecifications', 'users'])->where('asset_tag', $id)->first();
        return view('Pages/assetDetails', compact('item'));
    }

    public function store(StoreAssets $request)
    {
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
