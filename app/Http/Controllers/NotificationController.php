<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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

        $redirectUrl = $this->notificationService->getRedirectUrl($notif);
        return redirect($redirectUrl);
    }
}
