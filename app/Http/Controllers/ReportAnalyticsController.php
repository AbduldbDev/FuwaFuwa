<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportAnalyticsController extends Controller
{
    public function index()
    {
        if (!user()->canAccess('Reports', 'read')) {
            abort(403, 'Unauthorized');
        }

        return view('Pages/reports');
    }
}
