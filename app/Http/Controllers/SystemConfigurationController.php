<?php

namespace App\Http\Controllers;

use App\Services\SystemService;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\CompanyProfile;
use App\Http\Requests\System\CompanyProfileRequest;
use App\Http\Requests\System\StoreConfigurationRequest;

class SystemConfigurationController extends Controller
{
    protected SystemService $systemService;

    public function __construct(SystemService $systemService)
    {
        $this->systemService = $systemService;
    }

    private function authorizeRead(): void
    {
        if (!user()->canAccess('System', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeWrite(): void
    {
        if (!user()->canAccess('System', 'write')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();

        $data = $this->systemService->getRolesData();

        return view('Pages/system', $data);
    }

    public function saveRole(Request $request)
    {
        $this->authorizeWrite();

        try {
            $this->systemService->savePermissions($request->permissions);

            return redirect()->back()->with('success', 'Permissions updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function updateOrCreate(CompanyProfileRequest $request)
    {
        $this->authorizeWrite();

        try {
            $this->systemService->updateOrCreate($request->validated());

            return redirect()->back()->with('success', 'Company profile saved successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }

    public function saveSettings(StoreConfigurationRequest $request)
    {
        $this->authorizeWrite();

        try {
            $this->systemService->saveSettings($request->validated());

            return redirect()->back()->with('success', 'System configuration saved successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
