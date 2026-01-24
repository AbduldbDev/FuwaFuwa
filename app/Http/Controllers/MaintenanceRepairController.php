<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceRepairController extends Controller
{
    public function index()
    {
        return view('Pages/maintenance');
    }
}
