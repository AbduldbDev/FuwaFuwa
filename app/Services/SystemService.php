<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\CompanyProfile;

class SystemService
{
    protected array $roles = ['admin', 'encoder', 'viewer'];
    protected array $modules = ['Dashboard', 'Assets', 'Asset Request', 'Asset Archive', 'Maintenance', 'User', 'Vendor', 'Reports', 'System'];
    protected array $accessTypes = ['none' => 'None', 'read' => 'Read', 'write' => 'Read/Write', 'custom' => 'Custom'];

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
        return CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => $data['company_name'],
                'brand_name' => $data['brand_name'],
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'],
            ]
        );
    }
}
