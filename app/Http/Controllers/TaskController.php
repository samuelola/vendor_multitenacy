<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\TaskNotFoundException;
use App\Jobs\ProcessTask;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Auth\Access\Response;

class TaskController extends Controller
{
   public function addTask(Task $task){
        if(Gate::denies('create',$task)){
            return abort(403,'forbidden for this action');
           //return  Response::deny('You do not have permission for this');
        };
        $allprojects = Project::orderByDesc("id")->get();
          return view('addtask',compact('allprojects'));
        
        
   }

   public function storeTask(TaskRequest $request){
        $data = $request->validated();
        $task = Task::create($data);   
        ProcessTask::dispatch($task);     
        return redirect()->route('dashboard');
   }

   public function edit_task($id,TaskService $taskService){
        
        try{
          //$get_task = (new TaskService())->findByTaskId($id);
          $get_task = $taskService->findByTaskId($id);
        }

           //laravel default exception
     //    catch(ModelNotFoundException $exception){
     //      return view('tasknotfound', ['error' => $exception->getMessage()]);
     //    }

        catch(TaskNotFoundException $exception){
          return view('tasknotfound', ['error' => $exception->getMessage()]);
        }

        
        
        return view('edit_task',compact('get_task'));
   }

   public function delete_task($id,Task $task){
          if(Gate::denies('delete',$task)){
            return abort(403,'forbidden for this action');
          };
          $get_task = Task::where('id',$id)->first(); 
          $get_task->delete();
          return redirect()->route('dashboard');
   }
}
