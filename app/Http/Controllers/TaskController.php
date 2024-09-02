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

class TaskController extends Controller
{
   public function addTask(){
        $allprojects = Project::orderByDesc("id")->get();
        return view('addtask',compact('allprojects'));
   }

   public function storeTask(TaskRequest $request){
        $data = $request->validated();
        Task::create($data);        
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

   public function delete_task($id){
       
          $get_task = task::where('id',$id)->first(); 
          $get_task->delete();
          return redirect()->route('dashboard');
   }
}
