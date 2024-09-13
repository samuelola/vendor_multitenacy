<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interface\TaskInterface;

class TaskRepository implements TaskInterface{

    public function createTask($taskData){
        $task =  Task::create($taskData);
        return $task;
    }
}