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
         $uploaded = $this->uploadToCloudinary($request->file('avatar'), 'treskudos/avatars');
            if ($uploaded) $data['avatar'] = $uploaded;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated!');
    }
    private function uploadToCloudinary($file, $folder = 'treskudos') {
    try {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey    = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $timestamp = time();
        $signature = sha1("folder={$folder}&timestamp={$timestamp}{$apiSecret}");

        $response = \Illuminate\Support\Facades\Http::attach(
            'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
        )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
            'api_key'   => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder'    => $folder,
        ]);

        return $response->json()['secure_url'] ?? null;
    } catch (\Exception $e) {
        return null;
    }
}
}