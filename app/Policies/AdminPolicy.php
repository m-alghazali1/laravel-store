<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Admins', 'admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Admin $admin): bool
    {
        return $user->hasPermissionTo('Read-Admins', 'admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Admin', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Admin $admin): bool
    {
        return $user->hasPermissionTo('Update-Admin', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Admin $admin): bool
    {
        return $user->hasPermissionTo('Delete-Admin', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Admin $admin): bool
    {
        return false; // Typically, restoring is not allowed for admins
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Admin $admin): bool
    {
        return false; // Typically, force deletion is not allowed for admins
    }
}
