<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        Role::create(['name' => 'Store Owner', 'guard_name' => 'vendor']);
        Role::create(['name' => 'Customer', 'guard_name' => 'user']);
    }
}
