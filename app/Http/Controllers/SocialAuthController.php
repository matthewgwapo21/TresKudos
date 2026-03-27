<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller {

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }

        $user = User::updateOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'avatar'    => $googleUser->getAvatar(),
                'google_id' => $googleUser->getId(),
                'password'  => null,
            ]
        );

        Auth::login($user, true);

        return redirect()->route('home');
    }
}