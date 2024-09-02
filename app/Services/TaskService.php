<?php
namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use App\Exceptions\TaskNotFoundException;

class TaskService{

    public function findByTaskId($task_id){
         $task = Task::where('id',$task_id)->first();
         if(!$task){
            //throw new ModelNotFoundException("Task Not found!");
            throw new TaskNotFoundException("Task Not found!");
            
         }
         return $task;
    }
}