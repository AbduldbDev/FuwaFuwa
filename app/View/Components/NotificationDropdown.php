<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public $notifications;
    public $unreadCount;

    public function __construct()
    {
        if (Auth::check()) {
            $this->notifications = Notification::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            $this->unreadCount = Notification::where('user_id', Auth::id())
                ->whereNull('read_at')
                ->count();
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function render()
    {
        return view('components.notification-dropdown');
    }
}
