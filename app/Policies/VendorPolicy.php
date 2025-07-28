<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Auth\Access\Response;

class VendorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Vendors', 'admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Vendor $vendor): bool
    {
        return $user->hasPermissionTo('Read-Vendors', 'admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Vendor', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Vendor $vendor): bool
    {
        return $user->hasPermissionTo('Update-Vendor', 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Vendor $vendor): bool
    {
        return $user->hasPermissionTo('Delete-Vendor', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Vendor $vendor): bool
    {

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Vendor $vendor): bool
    {
        //
    }
}
