<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\NotificationHelper;


class AdminUserController extends Controller {
    public function index() {
        $users = User::withCount('recipes', 'favorites')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

public function promote(User $user) {
    $user->update(['role' => 'admin']);

    NotificationHelper::send(
        $user->id,
        'admin',
        '🎉 You are now an Admin!',
        'Congratulations! You have been granted admin privileges on TresKudos. You can now access the admin dashboard.',
        route('admin.dashboard')
    );

    return back()->with('success', $user->name . ' is now an admin!');
}

public function demote(User $user) {
    if ($user->id === auth()->id()) {
        return back()->with('error', 'You cannot remove your own admin role.');
    }

    $user->update(['role' => 'user']);

    NotificationHelper::send(
        $user->id,
        'admin',
        'Admin privileges removed',
        'Your admin privileges on TresKudos have been removed by an administrator.',
        route('home')
    );

    return back()->with('success', $user->name . ' is no longer an admin.');
}
}