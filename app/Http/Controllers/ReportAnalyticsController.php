<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportAnalyticsController extends Controller
{
    public function index()
    {
        return view('Pages/reports');
    }
}
