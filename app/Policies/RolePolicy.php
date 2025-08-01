<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('Read-Roles', 'admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo('Read-Roles', 'admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('Create-Role', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo('Update-Role', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo('Delete-Role', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Role $role): bool
    {
        //
    }
}
