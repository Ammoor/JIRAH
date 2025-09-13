<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('owns_resource', fn(User $user, Model $resource) => $user->id === $resource->user_id);

        Gate::define('is_admin', fn(User $user) => $user->role === 'admin');

        Gate::define('is_user', fn(User $user) => $user->role !== 'admin');

        Gate::define('is_user_active', fn(User $user) => $user->is_active == true);

        Gate::define('is_user_verified', fn(User $user) => $user->is_email_verified == true);
    }
}
