<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\User;
use App\Listeners\SendNewProjectNotification;
use App\Listeners\SendNewUserNotification;
use Illuminate\Support\Facades\Event;
use App\Observers\RegisterObserver;

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
         Schema::defaultStringLength(191);
        //  User::observe(RegisterObserver::class);

        Event::listen(
            SendNewUserNotification::class,
            SendNewProjectNotification::class
            
        );
    }
}
