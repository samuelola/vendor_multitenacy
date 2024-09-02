<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard(){
        $allprojects = Project::orderByDesc("id")->get();
        $alltasks = Task::orderByDesc("id")->get();
        
        $users = cache()->remember('note',3,function(){
            return User::orderByDesc("id")->get();
        });
        
        
        return view('dashboard',compact('allprojects','alltasks','users'));
    }

    public function markAsRead(){
       
       $users = cache()->remember('mark_read',3,function(){
          return User::all();
           foreach($users as $user){
            foreach($user->unreadNotifications as $notification){
                $notification->markAsRead();
                }
            }
       });
       
       
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
