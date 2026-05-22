<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ActivityHelper;

class AuthController extends Controller {

    public function registerForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
        ], [
            'password.min'   => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one letter and one number.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        ActivityHelper::log('Registered', $user->name . ' created a new account.');
        return redirect()->route('recipes.index'); 
    }

    public function loginForm() {
        return view('auth.login');
    }

public function login(Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
         ActivityHelper::log('Logged In', auth()->user()->name . ' logged in successfully.');
        $request->session()->regenerate();
        return redirect()->intended(route('recipes.index'));
       
    }

    return back()->withErrors([
        'email' => 'These credentials do not match our records.',
    ]);
}

    public function logout(Request $request) {
        ActivityHelper::log('Logged Out', auth()->user()->name . ' logged out.');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}