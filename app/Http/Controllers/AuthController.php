<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\SigninRequest;
// use App\Notifications\UserRegistration;
use App\Events\RegistrationProcessed;

class AuthController extends Controller
{
    public function signupForm(){

        return view('signup');
    }

    public function signup(SignupRequest $request){

        $data = $request->validated();
        $user = User::create($data); 
        $tenant = Tenant::create(['name'=>$request->name. 'Team']);
        $tenant->users()->attach($user->id);
        // event(new RegistrationProcessed($user));
        RegistrationProcessed::dispatch($user);
        Auth::login($user);
  
        return redirect()->route('dashboard');
    }

    public function signinForm(){

        return view('signin');
    }

    public function signin(SigninRequest $request){

        $credentials = $request->validated();
        if (Auth::attempt($credentials)) 
        {
             return redirect()->route('dashboard'); 
        }
        
        return back()->withErrors([
            'general_error' => 'The provided credentials do not match our records.',
        ]);
        // return 'Unauthorised, Wrong Email or Password';
  
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('signinform');
    }

    
}
