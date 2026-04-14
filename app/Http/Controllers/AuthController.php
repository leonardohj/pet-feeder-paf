<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Laravel\Socialite\Socialite;

class AuthController
{
    public function changeLang($langcode)
    {
        App::setLocale($langcode);
        session()->put("lang_code", $langcode);

        return redirect()->back();
    }
    public function showLogin(){
        return view('auth.login');
    }

    public function showRegister(){
        return view('auth.register');
    }

    public function redirect_google(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(Request $request)
    {
        $google_user = Socialite::driver('google')->stateless()->user();
        
        $user = User::where('email', $google_user->email)->first();
    
        if ($user) {
    
            if (!$user->google_id) {
                $user->google_id = $google_user->id;
                $user->save();
            }
    
        } else {
    
            $user = User::create([
                'name' => $google_user->name,
                'email' => $google_user->email,
                'google_id' => $google_user->id,
                'password' => bcrypt(Str::random(24)),
                'avatar' => $google_user->avatar
            ]);
    
        }
    
        Auth::login($user);
    
        return redirect()->route('home');
    }
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).*$/',
                'min:8',
                'confirmed'
            ],
        ]);

        $user = User::create($validation);
        
        Auth::login($user);

        return  redirect()->route('home');
    }

    public function login(Request $request){
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string'
            ]
        ]);

        if(Auth::attempt($validation))
        {
            $request->session()->regenerate();

            return  redirect()->route('home');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Sorry, incorrect credentials'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLogin');
    }
}
