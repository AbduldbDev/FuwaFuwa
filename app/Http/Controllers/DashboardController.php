<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {

        if (!user()->canAccess('Dashboard', 'read')) {
            abort(403, 'Unauthorized');
        }

        $data = $this->dashboardService->getDashboardData();

        return view('Pages/dashboard', $data);
    }
}
