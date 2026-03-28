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
                @if($user->avatar)
                @php $avatarUrl = str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/' . $user->avatar); @endphp
                    <img src="{{ $avatarUrl }}"
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
                <input type="password" name="password"
                       placeholder="At least 6 characters"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
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
@endsection