<?php

namespace App\Services;

use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Assets;
use Illuminate\Support\Facades\DB;

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
        return Maintenance::whereIn('status', ['Inspection', 'Corrective', 'Preventive', 'Completed'])->whereNotNull('start_date')
            ->latest()
            ->get();
    }

    public function getInEvent()
    {
        return Maintenance::whereIn('status', ['Inspection', 'Corrective', 'Preventive'])->whereNotNull('start_date')->latest()->get();
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
            ->orderByRaw("FIELD(priority, 'Emergency', 'High', 'Medium', 'Low')")->latest('updated_at')
            ->get();
    }

    public function getAllAssets()
    {
        return Assets::where('operational_status', '!=', 'archived')
            ->where('asset_type', 'Physical Asset')
            ->whereDoesntHave('maintenances', function ($q) {
                $q->where('status', '!=', 'Completed'); // Exclude only ongoing
            })
            ->latest()
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

    public function getRequestStatusCounts()
    {
        return Maintenance::whereNotNull('start_date')
            ->whereNotNull('status')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }

    public function getDashboardData(): array
    {

        return [
            'PendingCorrective' => $this->getPendingCorrective(),
            'Assets'  => $this->getAllAssets(),
            'ForInspection' => $this->getForInspection(),
            'InProgress' => $this->getInProgress(),
            'maintenanceEvents' => $this->getInEvent(),
            'TotalMaintenance' => $this->getTotalMaintenance(),
            'TotalInprogress' => $this->getTotalInProgress(),
            'TotalCompleted' => $this->getTotalCompleted(),
            'TotalHigh' => $this->getTotalHighPriority(),
            'RequestStatusCounts' => $this->getRequestStatusCounts(),
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
            'maintenance_id'   => $this->generateMaintenanceId('Corrective'),
            'maintenance_type' => 'Corrective',
            'start_date'       => $data['start_date'],
            'technician'       => !empty($data['technician']) ? $data['technician'] : $maintenance->technician,
            'status'           => 'Corrective',
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
            'completed_at' => Carbon::now()
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

        $status = $data['condition'] === 'Excellent - No Issues Found'
            ? 'Completed'
            : 'For Inspection';

        $updateData = [
            'documents'        => $data['document'] ?? $maintenance->documents,
            'technician'       => !empty($data['technician']) ? $data['technician'] : $maintenance->technician,
            'description'      => $data['description'] ?? $maintenance->description,
            'post_description' => $data['condition'] ?? $maintenance->post_description,
            'status'           => $status,
        ];

        if ($status === 'Completed') {
            $completedAt = Carbon::now();
            $nextMaintenance = null;

            switch ($maintenance->frequency) {
                case 'Weekly':
                    $nextMaintenance = $completedAt->copy()->addWeek();
                    break;

                case 'Monthly':
                    $nextMaintenance = $completedAt->copy()->addMonth();
                    break;

                case 'Quarterly':
                    $nextMaintenance = $completedAt->copy()->addMonths(3);
                    break;

                case 'Semi-Annual':
                    $nextMaintenance = $completedAt->copy()->addMonths(6);
                    break;
            }

            $updateData['completed_at']     = $completedAt;
            Assets::where('asset_tag', $maintenance->asset_tag)->update([
                'next_maintenance' => $nextMaintenance
            ]);
        }

        $maintenance->update($updateData);

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
