<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Vendor;
use App\Policies\AdminPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\VendorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Admin::class => AdminPolicy::class,
        Role::class => RolePolicy::class,
        Vendor::class => VendorPolicy::class
    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
