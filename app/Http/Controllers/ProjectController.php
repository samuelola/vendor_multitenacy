<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;
use App\Models\User;
// use App\Notifications\ProjectCreation;
use App\Events\ProjectProccessed;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class ProjectController extends Controller
{

    public function addProject(Request $request){
        return view('addproject');
    }
    public function storeProject(ProjectRequest $request){
        $data = $request->validated();
        $project=Project::create($data);      
        // User::find(Auth::user()->id)->notify(new ProjectCreation($project->name)); 
        // event(new ProjectProccessed($project));
        ProjectProccessed::dispatch($project);
        return redirect()->route('dashboard');
    }
    public function edit_project(Request $request,$id){

         try{
             //$get_project = Project::where('id',$id)->first();
               //this trigger the error
             $get_project = Project::where('id',$id)->firstOrFail();
             // An example of a fake model
            //$get_project->load(['projects']);
         }
        //  catch(\Exception $exception){
        //     dd(get_class($exception));
        //     return view('notfound');
        //  }

         catch(ModelNotFoundException $exception){
            return view('notfound');
         }
         catch(RelationNotFoundException $exception){
             return view('relationnotfound');
         }
         return view('edit_project',compact('get_project'));
    }

    public function update_project(ProjectRequest $request,$id){
         $get_project = Project::where('id',$id)->first();
         $data = $request->validated(); 
         $get_project->update($data);
         return redirect()->route('dashboard');
    }

    public function delete_project($id){
         $get_project = Project::where('id',$id)->first(); 
         $get_project->task()->delete();
         //this is used for many to many relationships
        //  $get_project->tasks->each->delete(); 
         $get_project->delete();
         return redirect()->route('dashboard');
    }
}
