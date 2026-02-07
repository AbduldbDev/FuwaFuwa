<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Assets\StoreAssets;
use App\Http\Requests\Assets\UpdateAssetRequest;
use App\Http\Requests\Assets\ArchiveAsset;
use App\Http\Requests\Assets\AssignAsset;
use App\Http\Requests\Assets\AddDocumentRequest;
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

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Assets', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeWrite(): void
    {
        if (!user()->canAccess('Assets', 'write')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();

        $data =  $this->assetService->getIndexData();
        return view('Pages.assets', $data);
    }

    public function show($id)
    {
        $this->authorizeRead();

        $data = $this->assetService->getShowData($id);

        return view('Pages/assetDetails', $data);
    }

    public function store(StoreAssets $request)
    {
        $this->authorizeWrite();

        try {
            $qty = (int) ($request->assetQuantity ?? 1);

            for ($i = 0; $i < $qty; $i++) {
                $this->assetService->store($request->validated());
            }

            return redirect()->back()->with('success', 'Asset created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateAssetRequest $request, $id)
    {
        $this->authorizeWrite();

        try {
            $asset = Assets::findOrFail($id);
            $this->assetService->updateAsset($asset, $request->validated());

            return redirect()->back()->with('success', 'Asset updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function assignAsset(AssignAsset $request)
    {
        $this->authorizeWrite();

        try {
            $this->assetService->assignAsset($request->validated());

            return redirect()->back()->with('success', 'Asset updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function delete(ArchiveAsset $request, $id)
    {
        $this->authorizeWrite();

        try {
            $this->assetService->deleteAsset($id, $request->validated());

            return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }


    public function deletedocument($id)
    {
        $this->authorizeWrite();

        try {
            $this->assetService->deleteDocument($id);

            return redirect()->back()->with('success', 'Document deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function addDocument(AddDocumentRequest $request, $assetId)
    {
        $this->authorizeWrite(); // your existing method

        try {
            $asset = Assets::findOrFail($assetId);

            $this->assetService->addDocument(
                $asset->id,
                $request->validated()['name'],
                $request->file('file')
            );

            return redirect()->back()->with('success', 'Document added successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
