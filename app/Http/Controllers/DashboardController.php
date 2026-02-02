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

    private function authorizeRead(): void
    {
        if (!user()->canAccess('Dashboard', 'read')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeRead();

        $data = $this->dashboardService->getDashboardData();
        
        return view('Pages/dashboard', $data);
    }
}
