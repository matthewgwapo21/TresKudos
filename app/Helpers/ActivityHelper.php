<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityHelper {
    public static function log($action, $description = null) {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'description'=> $description,
            'ip_address' => request()->ip(),
        ]);
    }
}