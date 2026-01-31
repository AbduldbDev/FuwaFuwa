<?php

namespace App\Services;

use App\Models\Vendors;
use Illuminate\Support\Arr;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class VendorService
{
    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function getTotalVendors()
    {
        return Vendors::count();
    }

    public function getTotalActiveVendors()
    {
        return Vendors::where('status', 'active')->count();
    }

    public function getTotalInactiveVendors()
    {
        return Vendors::where('status', 'Inactive')->count();
    }

    public function getVendors()
    {
        return Vendors::all();
    }

    public function create(array $data)
    {
        $data['vendor_id'] = $this->generateVendorId();

        $vendor = Vendors::create($data);

        $this->notification->notifyUsersWithModuleAccess(
            'Vendor',
            'write',
            'Vendor Created',
            "Vendor " . $vendor->name . " has been created by: " . Auth::user()->name . ".",
            'info'
        );
        return   $vendor;
    }

    public function updateVendor(array $data, Vendors $vendor): Vendors
    {

        $fillableData = Arr::only($data, $vendor->getFillable());
        $vendor->update($fillableData);

        $this->notification->notifyUsersWithModuleAccess(
            'Vendor',
            'write',
            'Vendor Updated',
            "Vendor " . $vendor->name . " has been updated by: " . Auth::user()->name . ".",
            'info'
        );

        return $vendor;
    }

    public function deleteVendor(int $id)
    {
        $Vendor = Vendors::findOrFail($id);

        $this->notification->notifyUsersWithModuleAccess(
            'Vendor',
            'write',
            'Vendor Updated',
            "Vendor " . $Vendor->name . " has been deleted by: " . Auth::user()->name . ".",
            'warning'
        );

        $Vendor->delete();

        return $Vendor;
    }

    public function getVendorsData()
    {
        return [
            'totalVendors' => $this->getTotalVendors(),
            'totalActive' => $this->getTotalActiveVendors(),
            'totalInactive' => $this->getTotalInactiveVendors(),
            'items' => $this->getVendors(),
        ];
    }

    private function generateVendorId(): string
    {
        $lastVendor = Vendors::orderBy('id', 'desc')->first();

        $nextNumber = $lastVendor
            ? ((int) substr($lastVendor->vendor_id, 4)) + 1
            : 1;

        return 'VND-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
