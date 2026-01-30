<?php

namespace App\Http\Controllers;

use App\Services\VendorService;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\StoreVendor;
use App\Http\Requests\Vendors\UpdateVendor;
use App\Models\Vendors;

class VendorController extends Controller
{
    protected VendorService $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function index()
    {
        if (!user()->canAccess('Vendor', 'read')) {
            abort(403, 'Unauthorized');
        }

        $data = $this->vendorService->getVendorsData();

        return view('Pages/vendor', $data);
    }

    public function store(StoreVendor $request)
    {
        if (!user()->canAccess('Vendor', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->vendorService->create($request->validated());

            return redirect()->back()->with('success', 'Vendor created successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateVendor $request, Vendors $vendor)
    {
        if (!user()->canAccess('Vendor', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->vendorService->updateVendor($request->validated(), $vendor);

            return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        if (!user()->canAccess('Vendor', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->vendorService->deleteVendor($id);

            return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
