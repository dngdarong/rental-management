<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('manage-admin-tenants', function (User $user) {
            return $user->isSuperAdmin();
        });

        Gate::define('access-admin-panel', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdminTenant();
        });
    }
}

