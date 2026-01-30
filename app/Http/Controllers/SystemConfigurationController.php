<?php

namespace App\Http\Controllers;

use App\Services\SystemService;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\CompanyProfile;
use App\Http\Requests\System\CompanyProfileRequest;

class SystemConfigurationController extends Controller
{
    protected SystemService $systemService;

    public function __construct(SystemService $systemService)
    {
        $this->systemService = $systemService;
    }

    public function index()
    {
        if (!user()->canAccess('System', 'read')) {
            abort(403, 'Unauthorized');
        }

        $data = $this->systemService->getRolesData();

        return view('Pages/system', $data);
    }

    public function saveRole(Request $request)
    {
        if (!user()->canAccess('System', 'write')) {
            abort(403, 'Unauthorized');
        }

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
        if (!user()->canAccess('System', 'write')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->systemService->updateOrCreate($request->validated());

            return redirect()->back()->with('success', 'Company profile saved successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
