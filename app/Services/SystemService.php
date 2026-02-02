<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\CompanyProfile;
use Illuminate\Support\Arr;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class SystemService
{
    protected array $roles = ['admin', 'encoder', 'viewer'];
    protected array $modules = ['Dashboard', 'Assets', 'Asset Request', 'Asset Archive', 'Maintenance', 'User', 'Vendor', 'Reports', 'System'];
    protected array $accessTypes = ['none' => 'None', 'read' => 'Read', 'write' => 'Read/Write'];

    protected $notification;

    public function __construct(NotificationService $notification)
    {
        $this->notification = $notification;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getModules(): array
    {
        return $this->modules;
    }

    public function getAccessTypes(): array
    {
        return $this->accessTypes;
    }

    public function getPermissions(): array
    {
        $allPermissions = Permission::all();
        $permissions = [];

        foreach ($this->roles as $role) {
            foreach ($this->modules as $module) {
                $perm = $allPermissions->first(fn($item) => $item->role === $role && $item->module === $module);
                $permissions[$role][$module] = $perm?->access ?? 'none';
            }
        }

        return $permissions;
    }

    public function getCompanyProfile()
    {
        return CompanyProfile::first();
    }

    public function getRolesData()
    {
        return [
            'roles' => $this->getRoles(),
            'modules' => $this->getModules(),
            'accessTypes' => $this->getAccessTypes(),
            'permissions' => $this->getPermissions(),
            'CompanyProfile' => $this->getCompanyProfile(),
        ];
    }

    public function savePermissions(array $permissions): void
    {
        foreach ($permissions as $role => $modules) {
            foreach ($modules as $module => $access) {
                Permission::updateOrCreate(
                    ['role' => $role, 'module' => $module],
                    ['access' => $access]
                );
            }
        }
    }

    public function updateOrCreate(array $data)
    {
        $fillableData = Arr::only($data, (new CompanyProfile)->getFillable());

        $this->notification->notifyUsersWithModuleAccess(
            'System',
            'read',
            'Company Profile Updated',
            "Company information was updated by " . Auth::user()->name . ".",
            'info'
        );

        return CompanyProfile::updateOrCreate(['id' => 1], $fillableData);
    }
}
