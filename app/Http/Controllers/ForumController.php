<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class ForumController extends Controller {

    public function index(Request $request) {
        $query = ForumTopic::with('user')->withCount('replies');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $topics = $query->orderByDesc('is_pinned')
                        ->latest()
                        ->paginate(15);

        return view('forum.index', compact('topics'));
    }

    public function show(ForumTopic $topic) {
        $topic->load('user', 'replies.user');
        return view('forum.show', compact('topic'));
    }

    public function create() {
        return view('forum.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'    => 'required|string|max:255',
            'body'     => 'required|string',
            'category' => 'required|in:general,recipe-help,feedback,bug-report',
        ]);

        $topic = ForumTopic::create([
            'user_id'  => auth()->id(),
            'title'    => $request->title,
            'body'     => $request->body,
            'category' => $request->category,
        ]);

        // Notify all admins
        User::where('role', 'admin')->get()->each(function($admin) use ($topic) {
            NotificationHelper::send(
                $admin->id,
                'forum',
                'New forum topic posted!',
                auth()->user()->name . ' posted: "' . $topic->title . '"',
                route('forum.show', $topic)
            );
        });

        return redirect()->route('forum.show', $topic)
            ->with('success', 'Topic posted successfully!');
    }

    public function reply(Request $request, ForumTopic $topic) {
        if ($topic->is_closed) {
            return back()->with('error', 'This topic is closed.');
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        ForumReply::create([
            'user_id'        => auth()->id(),
            'forum_topic_id' => $topic->id,
            'body'           => $request->body,
        ]);

        // Notify topic owner
        if ($topic->user_id !== auth()->id()) {
            NotificationHelper::send(
                $topic->user_id,
                'forum',
                'Someone replied to your topic!',
                auth()->user()->name . ' replied to "' . $topic->title . '"',
                route('forum.show', $topic)
            );
        }

        return back()->with('success', 'Reply posted!');
    }

    public function destroy(ForumTopic $topic) {
        if (auth()->id() !== $topic->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $topic->delete();
        return redirect()->route('forum.index')->with('success', 'Topic deleted.');
    }

    public function destroyReply(ForumReply $reply) {
        if (auth()->id() !== $reply->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $reply->delete();
        return back()->with('success', 'Reply deleted.');
    }
}