@extends('layouts.app')
@section('title', 'Edit Profile — TresKudos')

@section('content')
<div class="max-w-xl mx-auto">

    <a href="{{ route('profile.show') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition mb-6">
        ← Back to profile
    </a>

    <h1 class="brand text-4xl font-black text-gray-900 mb-2">Edit <span class="text-orange-500">Profile</span></h1>
    <p class="text-gray-400 mb-8">Update your personal information</p>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Avatar -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Profile Photo</h2>
           <div class="flex items-center gap-6">
            @if($user->avatar && str_starts_with($user->avatar, 'http'))
                <img src="{{ $user->avatar }}"
                    class="w-20 h-20 rounded-full object-cover border-4 border-orange-100"
                    alt="{{ $user->name }}">
            @else
                    <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center text-2xl font-black text-orange-400">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
            @endif
                <div class="flex-1">
                    <input type="file" name="avatar" accept="image/*"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG up to 2MB</p>
                </div>
            </div>
        </div>

        <!-- Basic info -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
            <h2 class="font-semibold text-gray-900">Basic Info</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                       class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">Email cannot be changed</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio</label>
                <textarea name="bio" rows="3" maxlength="500"
                          placeholder="Tell the community about yourself..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Max 500 characters</p>
            </div>
        </div>

        <!-- Change password -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
            <h2 class="font-semibold text-gray-900">Change Password</h2>
            <p class="text-sm text-gray-400">Leave blank to keep your current password</p>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">New password</label>
                <div class="relative">
    <input type="password" name="password" id="password" required
           placeholder="••••••••"
           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm pr-12 focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
    <button type="button" onclick="togglePassword('password')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
        <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
    </button>
</div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm new password</label>
                <input type="password" name="password_confirmation"
                       placeholder="••••••••"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
            </div>
        </div>

        <button type="submit"
                class="btn-primary w-full text-white font-semibold py-4 rounded-xl text-sm">
            Save Changes →
        </button>
    </form>
</div>
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const eye = document.getElementById('eye-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
<!-- Danger Zone -->
<div class="bg-white rounded-2xl border border-red-100 p-6 mt-6">
    <h2 class="font-semibold text-red-600 mb-1">Danger Zone</h2>
    <p class="text-gray-400 text-sm mb-4">Once you delete your account all your data will be permanently removed. This cannot be undone.</p>

    <button onclick="document.getElementById('delete-modal').classList.remove('hidden')"
            class="bg-red-50 hover:bg-red-100 text-red-500 font-medium px-5 py-2.5 rounded-xl text-sm transition">
        Delete My Account
    </button>
</div>

<!-- Delete confirmation modal -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md mx-4 shadow-2xl">
        <h3 class="brand text-2xl font-black text-gray-900 mb-2">Delete Account</h3>
        <p class="text-gray-500 text-sm mb-6">Enter your password to confirm. This action is permanent and cannot be undone.</p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="delete-password" required
                           placeholder="Enter your password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-12 text-sm focus:outline-none focus:border-red-400 transition">
                    <button type="button" onclick="togglePassword('delete-password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="eye-delete-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('delete-modal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 rounded-xl text-sm transition">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white font-medium py-3 rounded-xl text-sm transition">
                    Yes, Delete Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection