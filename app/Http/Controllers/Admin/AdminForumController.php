<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;

class AdminForumController extends Controller {

    public function index() {
        $topics = ForumTopic::with('user')
            ->withCount('replies')
            ->latest()
            ->paginate(20);
        return view('admin.forum', compact('topics'));
    }

    public function pin(ForumTopic $topic) {
        $topic->update(['is_pinned' => !$topic->is_pinned]);
        return back()->with('success', $topic->is_pinned ? 'Topic pinned!' : 'Topic unpinned.');
    }

    public function close(ForumTopic $topic) {
        $topic->update(['is_closed' => !$topic->is_closed]);
        return back()->with('success', $topic->is_closed ? 'Topic closed.' : 'Topic reopened.');
    }

    public function destroy(ForumTopic $topic) {
        $topic->delete();
        return back()->with('success', 'Topic deleted.');
    }
}