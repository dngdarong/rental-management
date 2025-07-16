<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Import Gate facade
use App\Models\User; // Import User model

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define a gate for 'manage-admin-tenants'
        // Only Super Admins can manage Admin Tenants
        Gate::define('manage-admin-tenants', function (User $user) {
            return $user->isSuperAdmin();
        });

        // Define a gate for 'access-admin-panel'
        // Both Super Admins and Admin Tenants can access the admin panel
        Gate::define('access-admin-panel', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdminTenant();
        });
    }
}

