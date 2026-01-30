<?php

namespace App\Http\Controllers;

use App\Services\CompanyProfileService;
use Illuminate\Http\Request;

use App\Models\CompanyProfile;
use App\Http\Requests\System\CompanyProfileRequest;

class SystemConfigurationController extends Controller
{
    protected CompanyProfileService $CompanyProfileService;

    public function __construct(CompanyProfileService $CompanyProfileService)
    {
        $this->CompanyProfileService = $CompanyProfileService;
    }

    public function index()
    {
        if (!user()->canAccess('System', 'read')) {
            abort(403, 'Unauthorized');
        }

        $CompanyProfile = CompanyProfile::first();
        return view('Pages/system', compact('CompanyProfile'));
    }

    public function updateOrCreate(CompanyProfileRequest $request)
    {
        if (!user()->canAccess('System', 'read')) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->CompanyProfileService->updateOrCreate($request->validated());

            return redirect()->back()->with('success', 'Company profile saved successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors([
                'system' => $e->getMessage(),
            ]);
        }
    }
}
