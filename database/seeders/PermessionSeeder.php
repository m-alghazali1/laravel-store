<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission::create(['name' => 'Read-Products', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Create-Product', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Product', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Product', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Restore-Product', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Force-Product', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Read-Categories', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Create-Category', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Category', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Category', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Admin', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Read-Products', 'guard_name' => 'vendor']);
        // Permission::create(['name' => 'Create-Product', 'guard_name' => 'vendor']);
        // Permission::create(['name' => 'Update-Product', 'guard_name' => 'vendor']);
        // Permission::create(['name' => 'Delete-Product', 'guard_name' => 'vendor']);

        // Permission::create(['name' => 'Read-Vendors', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Create-Vendor', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Vendor', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Vendor', 'guard_name' => 'admin']);

        // Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Read-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Create-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-User', 'guard_name' => 'admin']);

    }
}
