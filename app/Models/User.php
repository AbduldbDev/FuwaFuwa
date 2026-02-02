<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'employee_id',
        'department',
        'name',
        'username',
        'email',
        'password',
        'status',
        'user_type',
        'otp',
        'must_reset_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccess(string $module, string $action = 'read'): bool
    {
        $permission = Permission::where('role', $this->user_type)
            ->where('module', $module)
            ->first();

        if (!$permission) {
            return false;
        }

        $access = $permission->access;

        if ($access === 'write') return true;
        if ($access === 'read' && $action === 'read') return true;
        if ($access === 'custom') return true;

        return false;
    }
}
