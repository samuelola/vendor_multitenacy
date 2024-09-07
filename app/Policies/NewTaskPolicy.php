<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class NewTaskPolicy
{
    /**
     * Create a new policy instance.
     */
    
     public function create(User $user)
    {
        return $user->is_admin;
    }

    public function delete(User $user)
    {
       return $user->is_admin;
    }
}
