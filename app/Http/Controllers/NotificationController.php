<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $items = Notification::where('user_id', Auth::id())->latest()->get();
        return view('Pages/notifications', compact('items'));
    }

    public function read($id)
    {
        $notif = Notification::findOrFail($id);
        if ($notif->user_id === Auth::id()) {
            $notif->read_at = now();
            $notif->save();
        }
        return redirect()->back();
    }
}
