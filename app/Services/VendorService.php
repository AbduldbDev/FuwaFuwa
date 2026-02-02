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
        return Vendors::with(['documents', 'purchases'])->get();
    }

    public function create(array $data)
    {

        $data['vendor_id'] = $this->generateVendorId();

        $vendor = Vendors::create($data);

        // Handle documents if they exist
        if (!empty($data['documents']['name']) && is_array($data['documents']['name'])) {
            foreach ($data['documents']['name'] as $index => $name) {
                $filePath = null;

                // Check if file exists at this index
                if (
                    isset($data['documents']['file'][$index]) &&
                    $data['documents']['file'][$index] instanceof \Illuminate\Http\UploadedFile
                ) {

                    $file = $data['documents']['file'][$index];
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    // Generate unique filename
                    $filename = 'vendor_' . $vendor->id . '_' . time() . '_' . $index . '.' . $extension;

                    // Store the file
                    $filePath = $file->storeAs('vendor_documents', $filename, 'public');
                }

                VendorDocuments::create([
                    'vendor_id' => $vendor->id,
                    'name' => $name,
                    'file' => $filePath,
                    'expiration' => $data['documents']['expiry'][$index] ?? null,
                ]);
            }
        }

        // Handle purchases
        if (!empty($data['purchases']['po_id']) && is_array($data['purchases']['po_id'])) {
            foreach ($data['purchases']['po_id'] as $index => $poId) {
                VendorPurchase::create([
                    'vendor_id' => $vendor->id,
                    'order_id' => $poId,
                    'item_name' => $data['purchases']['item'][$index] ?? null,
                    'quantity' => $data['purchases']['quantity'][$index] ?? 0,
                    'cost' => $data['purchases']['cost'][$index] ?? 0,
                    'expiration' => $data['purchases']['expiration'][$index] ?? null,
                ]);
            }
        }

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
        DB::transaction(function () use ($vendor, $data) {

            // 1️⃣ Update basic vendor info
            $vendor->update([
                'name' => $data['name'],
                'contact_person' => $data['contact_person'],
                'contact_email' => $data['contact_email'],
                'contact_number' => $data['contact_number'],
                'category' => $data['category'],
                'status' => $data['status'],
            ]);

            // 2️⃣ Delete marked documents
            if (!empty($data['delete_documents'])) {
                VendorDocuments::whereIn('id', $data['delete_documents'])->delete();
            }

            // 3️⃣ Update existing documents
            if (!empty($data['existing_documents'])) {
                foreach ($data['existing_documents'] as $doc) {
                    VendorDocuments::where('id', $doc['id'])
                        ->update([
                            'name' => $doc['name'],
                            'expiration' => $doc['expiration'],
                        ]);
                }
            }

            // 4️⃣ Add new documents
            if (!empty($data['new_documents']['name'])) {
                foreach ($data['new_documents']['name'] as $i => $name) {
                    VendorDocuments::create([
                        'vendor_id' => $vendor->id,
                        'name' => $name,
                        'file' => $data['new_documents']['file_name'][$i], // adjust if handling real file upload
                        'expiration' => $data['new_documents']['expiry'][$i],
                    ]);
                }
            }

            // 5️⃣ Delete marked purchases
            if (!empty($data['delete_purchases'])) {
                VendorPurchase::whereIn('id', $data['delete_purchases'])->delete();
            }

            // 6️⃣ Update existing purchases
            if (!empty($data['existing_purchases'])) {
                foreach ($data['existing_purchases'] as $purchase) {
                    VendorPurchase::where('id', $purchase['id'])
                        ->update([
                            'order_id' => $purchase['po_id'],
                            'item_name' => $purchase['item_name'],
                            'quantity' => $purchase['quantity'],
                            'cost' => $purchase['cost'],
                            'expiration' => $purchase['expiration'],
                        ]);
                }
            }

            // 7️⃣ Add new purchases
            if (!empty($data['new_purchases']['order_id'])) {
                foreach ($data['new_purchases']['order_id'] as $i => $orderId) {
                    VendorPurchase::create([
                        'vendor_id' => $vendor->id,
                        'order_id' => $orderId,
                        'item_name' => $data['new_purchases']['item_name'][$i],
                        'quantity' => $data['new_purchases']['quantity'][$i],
                        'cost' => $data['new_purchases']['cost'][$i],
                        'expiration' => $data['new_purchases']['expiration'][$i],
                    ]);
                }
            }
        });

        return $vendor->fresh();
    }
}
