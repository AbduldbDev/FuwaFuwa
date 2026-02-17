<?php

namespace App\Services;

use App\Models\MaintenanceLog;

class MaintenanceLogService
{
    public function createLog(string $maintenanceId, array $data)
    {
        return MaintenanceLog::create([
            'maintenance_id' => $maintenanceId,
            'type' => $data['type'] ?? null,
            'action_taken' => $data['action_taken'] ?? null,
            'asset_tag' => $data['asset_tag'] ?? null,
            'issue_description' => $data['issue_description'] ?? null,
            'parts_replaced' => $data['parts_replaced'] ?? null,
            'cost' => $data['cost'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'completion_date' => $data['completion_date'] ?? null,
            'technician_notes' => $data['technician_notes'] ?? null,
        ]);
    }
}
