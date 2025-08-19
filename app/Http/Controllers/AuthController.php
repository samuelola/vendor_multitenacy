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
use RealRashid\SweetAlert\Facades\Alert;
use Stichoza\GoogleTranslate\GoogleTranslate;


class AuthController extends Controller
{
    public function signupForm(){
        $translator = new GoogleTranslate();
        $translatedText = $translator->translate('Hello world!', 'en', 'fr');
        return view('signup', compact('translatedText'));
    }

    public function signup(SignupRequest $request){

        $data = $request->validated();
        $user = User::create($data); 
        $tenant = Tenant::create(['name'=>$request->name. 'Team']);
        $tenant->users()->attach($user->id);
        // event(new RegistrationProcessed($user));
        RegistrationProcessed::dispatch($user);
        Auth::login($user);
        Alert::toast('Welcome '.auth()->user()->name, 'success');
        return redirect()->route('dashboard');
    }

    public function signinForm(){
        
        return view('signin');
    }

    public function signin(SigninRequest $request){

        $credentials = $request->validated();
        if (Auth::attempt($credentials)) 
        {
           //Alert::success('Success', 'Success Message');
             Alert::toast('Welcome Back '.auth()->user()->name, 'success');
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


    // public function Currency(Request $request){
          
    //     $curl = curl_init();
            
    //         curl_setopt_array($curl, [
    //         	CURLOPT_URL => "https://v6.exchangerate-api.com/v6/237ba73f34653024c1350395/latest/USD",
    //         	CURLOPT_RETURNTRANSFER => true,
    //         	CURLOPT_ENCODING => "",
    //         	CURLOPT_MAXREDIRS => 10,
    //         	CURLOPT_TIMEOUT => 30,
    //         	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         	CURLOPT_CUSTOMREQUEST => "GET",
    //         	CURLOPT_HTTPHEADER => [
    //         		"Accept: application/com",
    //         	],
    //         ]);
            
    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);
            
    //         curl_close($curl);
            
    //         $result = json_decode($response);
    // }

    
}
