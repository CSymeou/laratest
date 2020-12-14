<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-teams', function(User $user){
            return $user->role == 'admin';
        });
        Gate::define('view-team', function(User $user){
            return $user->role == 'leader' || $user->role == 'admin';
        });
        Gate::define('manage-team', function(User $user){
            return $user->role == 'leader';
        });
        Gate::define('manage-tasks', function(User $user){
            return $user->role == 'leader' || $user->role == 'user' || $user->role == 'admin';
        });
        Gate::define('manage-users', function(User $user){
            return $user->role == 'leader' || $user->role == 'user' || $user->role == 'admin';
        });
        Gate::define('view-own-tasks', function(User $user){
            return $user->role == 'user';
        });
        Gate::define('manage-own-task', function(User $user, Task $task){
            return $user->id == $task->assignee_id;
        });
    }
}
