<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Listeners\SendNewProjectNotification;
use App\Listeners\SendNewUserNotification;
use Illuminate\Support\Facades\Event;
use App\Observers\RegisterObserver;
use Illuminate\Support\Facades\Gate;
use App\Policies\TaskPolicy;
use App\Policies\NewTaskPolicy;
use App\Models\Role;

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

        
        Gate::define('project_create', fn(User $user)=> $user->is_admin);
        Gate::define('product_create', fn(User $user)=> $user->is_admin);
        //this is set this way when we use middleware bcos is_admin is from middleware
        //Gate::define('task_create', fn(User $user)=> $user->is_admin);
        //Gate::define('task_create', fn(User $user)=> $user->role_id == 1);

        //Gate::define('task_create', fn(User $user)=> in_array($user->role_id,[Role::IS_ADMIN,Role::IS_USER]));
        //Gate::define('task_delete', fn(User $user)=> $user->is_admin);
        
        Gate::policy(Task::class,TaskPolicy::class);
    }
}
