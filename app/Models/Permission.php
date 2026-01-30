<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'role',
        'module',
        'access'
    ];

    public static function getRolePermission($role, $module)
    {
        return self::where('role', $role)->where('module', $module)->first()?->access ?? 'none';
    }
}
