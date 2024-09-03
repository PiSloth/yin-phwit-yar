<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(NotiComposerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isHR', function (User $user) {
            $roles = ['Admin', 'HR'];

            $data = UserRole::whereUserId($user->id)->get()->first();
            $name = $data->role->name;
            return in_array($name, $roles);
        });
    }
}
