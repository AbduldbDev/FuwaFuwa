<?php

namespace App\Services;

use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Assets;

class MaintenanceService
{
    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function getTotalMaintenance(): int
    {
        return Maintenance::whereNot('status', 'Completed')->count();
    }

    public function getTotalInProgress(): int
    {
        return Maintenance::where('status', 'In Progress')->count();
    }

    public function getTotalCompleted(): int
    {
        return Maintenance::where('status', 'Completed')->count();
    }

    public function getTotalHighPriority(): int
    {
        return Maintenance::where('priority', 'Emergency')->count();
    }

    public function getInProgress()
    {
        return Maintenance::whereIn('status', ['Inspection', 'Corrective', 'Preventive', 'Completed'])
            ->orderByRaw("FIELD(priority, 'Emergency', 'High', 'Medium', 'Low')")
            ->latest()
            ->get();
    }

    public function getPendingCorrective()
    {
        return Maintenance::where('maintenance_type', 'Corrective')->whereNull('start_date')
            ->orderByRaw("FIELD(priority, 'Emergency', 'High', 'Medium', 'Low')")
            ->get();
    }

    public function getForInspection()
    {
        return Maintenance::where('status', 'For Inspection')
            ->orderByRaw("FIELD(priority, 'Emergency', 'High', 'Medium', 'Low')")
            ->get();
    }

    public function getAllAssets()
    {
        return Assets::where('operational_status', '!=', 'archived')->latest()->get();
    }

    public function getMaintenanceEvents($maintenances)
    {
        $events = [];

        foreach ($maintenances as $m) {
            if ($m->start_date) {
                $date = Carbon::parse($m->start_date)->format('Y-m-d');
                $events[$date][] = strtolower($m->maintenance_type);
            }
        }

        return $events;
    }

    public function getDashboardData(): array
    {

        $inProgress = $this->getInProgress();

        return [
            'PendingCorrective' => $this->getPendingCorrective(),
            'Assets'  => $this->getAllAssets(),
            'ForInspection' => $this->getForInspection(),
            'InProgress' => $inProgress,
            'maintenanceEvents' => $this->getMaintenanceEvents($inProgress),
            'TotalMaintenance' => $this->getTotalMaintenance(),
            'TotalInprogress' => $this->getTotalInProgress(),
            'TotalCompleted' => $this->getTotalCompleted(),
            'TotalHigh' => $this->getTotalHighPriority(),
        ];
    }

    public function store(array $data)
    {

        if (!empty($data['document']) && is_array($data['document'])) {
            $paths = [];
            foreach ($data['document'] as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->storeAs('maintenance_docs', $filename, 'public');
                    $paths[] = '/storage/maintenance_docs/' . $filename;
                }
            }
            $data['documents'] = json_encode($paths);
        }

        $data['maintenance_id'] = $this->generateMaintenanceId($data['maintenance_type'] ?? null);
        $data['reported_by'] = Auth::id();
        $data['department'] = Auth::user()->department;
        $data['status'] = $data['maintenance_type'];

        $this->notification->notifyUsersWithModuleAccess(
            'Maintenance',
            'read',
            'New Maintenance Report',
            "New Maintenance " . $data['maintenance_id'] . " has been reported by: " . Auth::user()->name,
            'info'
        );

        return Maintenance::create($data);
    }

    public function updateSchedule(Maintenance $maintenance, array $data): Maintenance
    {
        $maintenance->update([
            'start_date' => $data['start_date'],
            'technician' => $data['technician'],
            'status' => 'Corrective'
        ]);


        $this->notification->notifyUsersWithModuleAccess(
            'Maintenance',
            'read',
            'Maintenance Updated',
            "Maintenance " . $maintenance->maintenance_id . " has been updated by: " . Auth::user()->name,
            'info'
        );

        return $maintenance;
    }

    public function updateInspectionSchedule(Maintenance $maintenance, array $data): Maintenance
    {
        $maintenance->update([
            'maintenance_id' => $this->generateMaintenanceId('Corrective'),
            'maintenance_type' => 'Corrective',
            'start_date' => $data['start_date'],
            'technician' => $data['technician'],
            'status' => 'Corrective'
        ]);


        $this->notification->notifyUsersWithModuleAccess(
            'Maintenance',
            'read',
            'Maintenance Updated',
            "Maintenance " . $maintenance->maintenance_id . " has been updated by: " . Auth::user()->name,
            'info'
        );

        return $maintenance;
    }


    public function updateCorrective(Maintenance $maintenance, array $data): Maintenance
    {
        if (!empty($data['post_attachments']) && is_array($data['post_attachments'])) {
            $paths = [];
            foreach ($data['post_attachments'] as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->storeAs('maintenance_docs', $filename, 'public');
                    $paths[] = '/storage/maintenance_docs/' . $filename;
                }
            }
            $data['post_attachments'] = json_encode($paths);
        }

        $maintenance->update([
            'post_description' => $data['post_description'],
            'post_replacements' => $data['post_replacements'],
            'technician_notes' => $data['technician_notes'],
            'post_attachments' => $data['post_attachments'] ?? '',
            'status' => 'Completed',

        ]);


        $this->notification->notifyUsersWithModuleAccess(
            'Maintenance',
            'read',
            'Maintenance Updated',
            "Maintenance " . $maintenance->maintenance_id . " has been updated by: " . Auth::user()->name,
            'info'
        );

        return $maintenance;
    }

    public function updateInspection(Maintenance $maintenance, array $data): Maintenance
    {
        if (!empty($data['document']) && is_array($data['document'])) {
            $paths = [];
            foreach ($data['document'] as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->storeAs('maintenance_docs', $filename, 'public');
                    $paths[] = '/storage/maintenance_docs/' . $filename;
                }
            }
            $data['document'] = json_encode($paths);
        }


        $status =  $data['condition'] === 'Excellent - No Issues Found' ? 'Completed' : 'For Inspection';


        $maintenance->update([
            'documents' =>  $data['document'] ?? '',
            'technician' =>  $data['technician'],
            'description' => $data['description'],
            'post_description' => $data['condition'],
            'status' => $status,
        ]);


        $this->notification->notifyUsersWithModuleAccess(
            'Maintenance',
            'read',
            'Maintenance Updated',
            "Maintenance " . $maintenance->maintenance_id . " has been updated by: " . Auth::user()->name,
            'info'
        );

        return $maintenance;
    }


    public function generateMaintenanceId(?string $type = null): string
    {
        switch (strtolower($type)) {
            case 'corrective':
                $prefix = 'COR';
                break;
            case 'preventive':
                $prefix = 'PRE';
                break;
            case 'inspection':
                $prefix = 'INS';
                break;
            default:
                $prefix = 'MT';
        }

        do {
            $number = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $maintenanceId = $prefix . '-' . $number;
        } while (Maintenance::where('maintenance_id', $maintenanceId)->exists());

        return $maintenanceId;
    }
}
