<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function notify(string $module, string $title, string $message, ?int $userId = null, string $type)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'module' => $module,
        ]);
    }

    public function notifyUsersWithModuleAccess(string $module, string $access, string $title, string $message, string $type): void
    {
        $allowedAccesses = $access === 'read'
            ? ['write', 'read']
            : ['write'];

        $roles = Permission::where('module', $module)
            ->whereIn('access', $allowedAccesses)
            ->pluck('role')
            ->unique();


        if ($roles->isEmpty()) {
            return;
        }

        $users = User::whereIn('user_type', $roles)->get();

        foreach ($users as $user) {
            $this->notify($module, $title, $message, $user->id, $type);
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

    public function getRedirectUrl(Notification $notif): string
    {
        switch ($notif->module) {
            case 'Asset Request':
                return route('asset-request.index');

            case 'Asset Archive':
                return route('assets-archive.index');

            case 'Maintenance':
                return route('maintenance-repair.index');

            case 'User':
                return route('user-management.index');

            case 'Vendor':
                return route('vendors.index');

            case 'Reports':
                return route('reports-analytics.index');

            case 'System':
                return route('system-configuration.index');

            case 'Assets':
                if (preg_match('/#([\w-]+)/', $notif->message, $matches)) {
                    $assetId = trim($matches[1]);
                    return url("/asset/show/{$assetId}");
                }
                return url()->previous(); 

            default:
                return url()->previous();
        }
    }
}
