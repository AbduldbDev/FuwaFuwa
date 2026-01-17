<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assets;


class DashboardController extends Controller
{
    public function index()
    {
        $items = Assets::get();
        $totalAssets = Assets::get()->count();

        return view('Pages/dashboard',  compact('items', 'totalAssets'));
    }
}
