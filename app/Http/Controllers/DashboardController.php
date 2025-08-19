<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(){
        $allprojects = Project::where('user_id',auth()->user()->id)->latest()->get();
        $alltasks = Task::where('user_id',auth()->user()->id)->latest()->get();
        $alldeleted_project = Project::withTrashed()->where('deleted_at','>',Carbon::now()->subWeek())->get();
        $users = User::orderByDesc("id")->get();
        $title = 'Are you sure you want to delete this record?';
        $text = "You won't be able to revert this!";
        confirmDelete($title, $text);
        return view('dashboard',compact('allprojects','alltasks','users','alldeleted_project'));
    }

    public function markAsRead(){
       
        $users =  User::all();
        foreach($users as $user){
          foreach($user->unreadNotifications as $notification){
            $notification->markAsRead();
            }
        }
       
         return redirect()->back();   
    }

    public function deleteNotification(){
        $users = User::all();
        foreach($users as $user){
           $user->notifications()->delete();
        }

        return redirect()->back(); 
    }
}
