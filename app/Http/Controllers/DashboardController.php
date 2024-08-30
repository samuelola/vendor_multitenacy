<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function dashboard(){
        $allprojects = Project::orderByDesc("id")->get();
        $alltasks = Task::orderByDesc("id")->get();
        return view('dashboard',compact('allprojects','alltasks'));
    }
}
