<?php

namespace App\Services;

use App\Models\MaintenanceLog;
use App\Models\Maintenance;

class MaintenanceLogService
{
    /**
     * Create or update a log for a maintenance
     * This will UPDATE existing log if found, otherwise CREATE new one
     */
    public function createOrUpdateLog(string $maintenanceId, array $data)
    {
        // Find the most recent log for this maintenance
        $log = MaintenanceLog::where('maintenance_id', $maintenanceId)
            ->latest()
            ->first();

        if ($log) {
            // Update existing log
            $log->update($data);
            return $log;
        }

        // Create new log if none exists
        return MaintenanceLog::create(array_merge(
            ['maintenance_id' => $maintenanceId],
            $data
        ));
    }

    /**
     * Update maintenance ID for logs (when maintenance ID changes)
     */
    public function updateMaintenanceId(string $oldMaintenanceId, string $newMaintenanceId, array $additionalData = [])
    {
        // Find the log with old ID
        $log = MaintenanceLog::where('maintenance_id', $oldMaintenanceId)
            ->latest()
            ->first();

        if ($log) {
            // Update the log with new ID and additional data
            $log->update(array_merge(
                ['maintenance_id' => $newMaintenanceId],
                $additionalData
            ));
            return $log;
        }

        // Create new log if none exists
        return MaintenanceLog::create(array_merge(
            ['maintenance_id' => $newMaintenanceId],
            $additionalData
        ));
    }

    /**
     * Get the latest log for a maintenance
     */
    public function getLatestLog(string $maintenanceId)
    {
        return MaintenanceLog::where('maintenance_id', $maintenanceId)
            ->latest()
            ->first();
    }

    /**
     * Get all logs for a maintenance (history)
     */
    public function getAllLogs(string $maintenanceId)
    {
        return MaintenanceLog::where('maintenance_id', $maintenanceId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
