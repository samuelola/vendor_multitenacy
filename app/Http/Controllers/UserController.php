<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id){

        try{
           $user = User::where('id',auth()->user()->id)->firstOrFail();
        }catch(\Exception $e){
           return $e->getMessage('user not found');
        }
        
        return view('dashboard',compact('user'));
    }
}
