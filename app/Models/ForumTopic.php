<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model {
    protected $fillable = ['user_id', 'title', 'body', 'category', 'is_pinned', 'is_closed'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function replies() {
        return $this->hasMany(ForumReply::class)->latest();
    }
}