<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;


class PetsController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pets = Pet::where('id_user', $user->id)->get();

        return view('pets.index', ['pets' => $pets]);
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
