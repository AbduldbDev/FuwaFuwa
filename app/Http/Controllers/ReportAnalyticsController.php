<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportAnalyticsController extends Controller
{

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

        return view('Pages/reports');
    }
}
