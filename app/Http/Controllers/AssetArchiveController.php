<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AssetService;

class AssetArchiveController extends Controller
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

        $items = $this->assetService->getAssetArchive();
        return view('Pages/assetArchive', compact('items'));
    }
}
