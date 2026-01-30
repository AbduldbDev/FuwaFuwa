<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceRepairController extends Controller
{
    public function index()
    {
        if (!user()->canAccess('Maintenance', 'read')) {
            abort(403, 'Unauthorized');
        }

        return view('Pages/maintenance');
    }
}
