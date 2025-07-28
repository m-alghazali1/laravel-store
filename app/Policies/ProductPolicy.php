<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Products', session('guard'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Product $product): bool
    {
        return $user->hasPermissionTo('Read-Products', session('guard'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        // $admin = auth('admin')->user(); // أو App\Models\Admin::find(رقم_المستخدم);
        // dump($admin);

        // dump($admin->getRoleNames());          // يعرض أسماء الأدوار المرتبطة بالمستخدم
        // dump($admin->getAllPermissions()->pluck('name'));  // يعرض أسماء الصلاحيات المرتبطة بالمستخدم

        return $user->hasPermissionTo('Create-Product', session('guard'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Product $product): bool
    {
        return $user->hasPermissionTo('Update-Product', session('guard'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Product $product): bool
    {
        return $user->hasPermissionTo('Delete-Product', session('guard'));
    }

    public function trash($user, Product $product): bool
    {
        return $user->hasPermissionTo('Delete-Product', session('guard'));
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, $id): bool
    {
        return $user->hasPermissionTo('Restore-Product', session('guard'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Product $product): bool
    {
        return $user->hasPermissionTo('Force-Product', session('guard'));
    }
}
