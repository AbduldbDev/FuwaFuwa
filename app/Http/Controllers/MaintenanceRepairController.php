<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\MaintenanceService;
use App\Http\Requests\Maintenance\StoreMaintenanceRequest;
use App\Http\Requests\Maintenance\UpdateMaintenanceRequest;
use App\Http\Requests\Maintenance\UpdateCorrectiveMaintenance;
use App\Http\Requests\Maintenance\UpdateInspectionMaintenance;
use App\Models\Maintenance;
use Carbon\Carbon;

class MaintenanceRepairController extends Controller
{

    protected MaintenanceService $maintenanceService;

    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Maintenance', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeWrite(): void
    {
        if (!user()->canAccess('Maintenance', 'write')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();

        $data =  $this->maintenanceService->getDashboardData();

        return view('Pages/maintenance', $data);
    }

    public function store(StoreMaintenanceRequest $request)
    {
        $this->authorizeWrite();

        try {
            $this->maintenanceService->store($request->validated());

            return redirect()->back()->with('success', 'Maintenance record created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        $this->authorizeWrite();

        try {
            $this->maintenanceService->updateSchedule($maintenance, $request->validated());

            return redirect()->back()->with('success', 'Maintenance updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function updateInspectionSchedule(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        $this->authorizeWrite();

        try {
            $this->maintenanceService->updateInspectionSchedule($maintenance, $request->validated());

            return redirect()->back()->with('success', 'Maintenance updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function updateCorrective(UpdateCorrectiveMaintenance $request, Maintenance $maintenance)
    {
        $this->authorizeWrite();

        try {
            $this->maintenanceService->updateCorrective($maintenance, $request->validated());

            return redirect()->back()->with('success', 'Maintenance updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }


    public function updateInspection(UpdateInspectionMaintenance $request, Maintenance $maintenance)
    {
        $this->authorizeWrite();

        try {
            $this->maintenanceService->updateInspection($maintenance, $request->validated());

            return redirect()->back()->with('success', 'Maintenance updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
