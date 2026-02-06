<?php

namespace App\Services;

use App\Models\Vendors;
use App\Models\VendorDocuments;
use App\Models\VendorPurchase;
use Illuminate\Support\Arr;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return Vendors::with(['documents', 'purchases'])->latest('updated_at')->get();
    }

    public function create(array $data)
    {

        $data['vendor_id'] = $this->generateVendorId();
        $vendor = Vendors::create($data);

        $this->notification->notifyUsersWithModuleAccess(
            'Vendor',
            'write',
            'Vendor Created',
            "Vendor {$vendor->name} has been created by: " . Auth::user()->name,
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


    public function updateVendor(Vendors $vendor, array $data)
    {

        $vendor->update([
            'name' => $data['name'],
            'contact_person' => $data['contact_person'],
            'contact_email' => $data['contact_email'],
            'contact_number' => $data['contact_number'],
            'category' => $data['category'],
            'status' => $data['status'],
        ]);



        $this->notification->notifyUsersWithModuleAccess(
            'Vendor',
            'read',
            'Vendor Updated',
            "Vendor {$vendor->name} has been updated by: " . Auth::user()->name,
            'info'
        );

        return $vendor->fresh();
    }
}
