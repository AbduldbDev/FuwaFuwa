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

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Asset Archive', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();

        $data = $this->assetService->getArchiveData();


        // return response()->json($data);
        return view('Pages/assetArchive', $data);
    }
}
