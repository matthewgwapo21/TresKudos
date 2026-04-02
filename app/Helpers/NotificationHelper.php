<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper {

    public static function send($userId, $type, $title, $message, $link = null) {
        Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'link'    => $link,
        ]);
    }
}