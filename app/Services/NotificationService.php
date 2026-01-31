<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function notify(string $title, string $message, ?int $userId = null, string $type)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }

    public function notifyUsersWithModuleAccess(string $module, string $access, string $title, string $message, string $type): void
    {
        $roles = Permission::where('module', $module)
            ->where('access', $access)
            ->pluck('role');

        if ($roles->isEmpty()) return;
        $users = User::whereIn('user_type', $roles)->get();

        foreach ($users as $user) {
            $this->notify($title, $message, $user->id, $type);
        }
    }

    public function getUserNotifications(int $userId)
    {
        return Notification::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function markAsRead(int $id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->read_at = now();
            $notification->save();
        }
        return $notification;
    }
}
