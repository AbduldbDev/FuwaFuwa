<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        if (!user()->canAccess('Vendor', 'read')) {
            abort(403, 'Unauthorized');
        }

        return view('Pages/vendor');
    }
}
