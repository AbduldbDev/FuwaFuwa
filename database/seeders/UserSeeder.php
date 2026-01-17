<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'employee_id'   => 'EMP-0001',
            'department'    => 'IT',
            'name'          => 'Admin Account',
            'username'      => 'adminaccount',
            'email'         => 'admin@gmail.com',
            'password'      =>  Hash::make('Password'),
            'user_type'     => 'admin',
            'status'        => 'active',
            'must_reset_password' => false,
        ]);
    }
}
