<?php

namespace App\Helpers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function log($activity)
    {
        $user = Auth::guard('admin')->user();

        Activity::create([
            'user_id' => $user ? $user->id : null,
            'activity' => $activity,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}