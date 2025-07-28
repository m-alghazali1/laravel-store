<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Category;

class CategoryPolicy
{
    public function viewAny( $user): bool
    {
        return $user->hasPermissionTo('Read-Categories', 'admin');
    }

    public function view( $user, Category $category): bool
    {
        return $user->hasPermissionTo('Read-Categories', 'admin');
    }

    public function create(Admin $user): bool
    {
        return $user->hasPermissionTo('Create-Category', 'admin');
    }

    public function update( $user, Category $category): bool
    {
        return $user->hasPermissionTo('Update-Category', 'admin');
    }

    public function delete( $user, Category $category): bool
    {
        return $user->hasPermissionTo('Delete-Category', 'admin');
    }

    public function restore( $user, Category $category): bool
    {
        return false;
    }

    public function forceDelete( $user, Category $category): bool
    {
        return false;
    }
}
