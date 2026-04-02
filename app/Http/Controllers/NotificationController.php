<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller {

    public function index() {
        $notifications = auth()->user()->notifications()->paginate(20);
        auth()->user()->unreadNotifications()->update(['is_read' => true]);
        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead() {
        auth()->user()->unreadNotifications()->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification) {
        if ($notification->user_id !== auth()->id()) abort(403);
        $notification->delete();
        return back();
    }
}