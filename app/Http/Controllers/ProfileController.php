<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {

    public function show() {
        $user    = auth()->user();
        $recipes = $user->recipes()->with('category')->latest()->paginate(6);
        return view('profile.show', compact('user', 'recipes'));
    }

    public function edit() {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'bio'      => 'nullable|string|max:500',
            'avatar'   => 'nullable|image|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'bio'  => $request->bio,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated!');
    }
}