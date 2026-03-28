<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;


class AdminUserController extends Controller {
    public function index() {
        $users = User::withCount('recipes', 'favorites')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

   public function promote(User $user) {
    $user->update(['role' => 'admin']);
    return back()->with('success', $user->name . ' is now an admin!');
}

public function demote(User $user) {
    if ($user->id === auth()->id()) {
        return back()->with('error', 'You cannot remove your own admin role.');
    }
    $user->update(['role' => 'user']);
    return back()->with('success', $user->name . ' is no longer an admin.');
}
}