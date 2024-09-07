<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use App\Models\Role;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, Task $task)
    {
        //return $user->is_admin;
        return $user->role_id == Role::IS_ADMIN;
        // you can specify 2 roles for any action
        //return in_array($user->role_id,[Role::IS_ADMIN,Role::IS_USER]); 
    }

    public function delete(User $user)
    {
       //return $user->is_admin;
       return $user->role_id == Role::IS_ADMIN;

    }
}
