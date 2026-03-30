<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AssetCategoryService;
use App\Http\Requests\AssetCategory\StoreCategory;
use App\Http\Requests\AssetCategory\UpdateCategory;
use App\Models\AssetCategory;

class AssetCategoryController extends Controller
{

    protected AssetCategoryService $assetCategoryService;

    public function __construct(AssetCategoryService $assetCategoryService)
    {
        $this->assetCategoryService = $assetCategoryService;
    }

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Asset Category', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeWrite(): void
    {
        if (!user()->canAccess('Asset Category', 'write')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();
        $items = $this->assetCategoryService->getCategories();

        return view('Pages/assetCategory', compact('items'));
    }

    public function store(StoreCategory $request)
    {
        $this->authorizeWrite();

        try {
            $this->assetCategoryService->create($request->validated());

            return redirect()->back()->with('success', 'Asset Category created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateCategory $request, $id)
    {
        $this->authorizeWrite();

        try {
            $this->assetCategoryService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Asset Category updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        $category = AssetCategory::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Asset Category deleted successfully.');
    }
    
}
