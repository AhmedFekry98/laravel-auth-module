<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Modules\Auth\Http\Middleware\RoleCheck;

class UserAccessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->alias('abilities', CheckAbilities::class);
        $this->app->alias('ability', CheckForAnyAbility::class);
        $this->app->alias(RoleCheck::class, 'role');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //  ? register the main permisions on system.
        $this->loadAndRegisterPermisions();
    }

    public function loadAndRegisterPermisions()
    {
        $permisions = config(('system.permisions'));


        foreach ($permisions as $ability => $check) {

            if ($check === null) {
                $check = fn () => true;
            }

            Gate::define($ability, $check);
        }
    }
}
