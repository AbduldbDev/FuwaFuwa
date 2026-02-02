<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\MaintenanceService;
use App\Http\Requests\Maintenance\StoreMaintenanceRequest;
use App\Http\Requests\Maintenance\UpdateMaintenanceRequest;
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

            return redirect()->back()->with('success', 'Maintenance schedule updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
