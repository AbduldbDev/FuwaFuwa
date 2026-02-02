<?php

namespace App\Services;

use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        return Maintenance::whereNot('status', 'Pending')
            ->orderByRaw("FIELD(priority, 'Emergency', 'High', 'Medium', 'Low')")
            ->latest()
            ->get();
    }

    public function getPending()
    {
        return Maintenance::where('status', 'Pending')
            ->orderByRaw("FIELD(priority, 'Emergency', 'High', 'Medium', 'Low')")
            ->get();
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
        $pending = $this->getPending();
        $inProgress = $this->getInProgress();

        return [
            'Pending' => $pending,
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

        if (isset($data['document']) && is_array($data['document'])) {
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
        $data['status'] = is_null($data['start_date']) ? 'Pending' : 'In Progress';

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
            'status' => 'In Progress'
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
