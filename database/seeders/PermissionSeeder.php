<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['role' => 'admin', 'module' => 'Dashboard', 'access' => 'read'],
            ['role' => 'admin', 'module' => 'Assets', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'Asset Request', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'Asset Archive', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'Maintenance', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'User', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'Vendor', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'Reports', 'access' => 'write'],
            ['role' => 'admin', 'module' => 'System', 'access' => 'write'],

            ['role' => 'encoder', 'module' => 'Dashboard', 'access' => 'read'],
            ['role' => 'encoder', 'module' => 'Assets', 'access' => 'write'],
            ['role' => 'encoder', 'module' => 'Asset Request', 'access' => 'write'],
            ['role' => 'encoder', 'module' => 'Asset Archive', 'access' => 'none'],
            ['role' => 'encoder', 'module' => 'Maintenance', 'access' => 'write'],
            ['role' => 'encoder', 'module' => 'User', 'access' => 'none'],
            ['role' => 'encoder', 'module' => 'Vendor', 'access' => 'none'],
            ['role' => 'encoder', 'module' => 'Reports', 'access' => 'read'],
            ['role' => 'encoder', 'module' => 'System', 'access' => 'none'],

            ['role' => 'viewer', 'module' => 'Dashboard', 'access' => 'read'],
            ['role' => 'viewer', 'module' => 'Assets', 'access' => 'read'],
            ['role' => 'viewer', 'module' => 'Asset Request', 'access' => 'none'],
            ['role' => 'viewer', 'module' => 'Asset Archive', 'access' => 'none'],
            ['role' => 'viewer', 'module' => 'Maintenance', 'access' => 'none'],
            ['role' => 'viewer', 'module' => 'User', 'access' => 'none'],
            ['role' => 'viewer', 'module' => 'Vendor', 'access' => 'none'],
            ['role' => 'viewer', 'module' => 'Reports', 'access' => 'write'],
            ['role' => 'viewer', 'module' => 'System', 'access' => 'none'],
        ]);
    }
}
