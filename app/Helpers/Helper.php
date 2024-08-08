<?php

namespace App\Helpers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function log($activity)
    {
        $admin = Auth::guard('admin')->user();
        $member = Auth::guard('member')->user();

        Activity::create([
            'user_id' => $admin ? $admin->id : null,
            'member_id' => $member ? $member->id : null,
            'activity' => $activity,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
