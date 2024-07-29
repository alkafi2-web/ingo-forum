<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Activity;

class UserController extends Controller
{
    public function activityList(Request $request)
    {
        if ($request->ajax()) {
            $activities = Activity::with('user')->get();
            // dd($activities);
            return DataTables::of($activities)
                ->addColumn('name', function ($activity) {
                    return $activity->user->name;
                })
                ->addColumn('ip', function ($activity) {
                    return $activity->ip_address;
                })
                ->addColumn('activity', function ($activity) {
                    return $activity->activity;
                })
                ->addColumn('device_browser', function ($activity) {
                    return $activity->user_agent;
                })
                ->addColumn('datetime', function ($activity) {
                    return $activity->created_at->format('d M Y H:i:s');
                })
                ->make(true);
        }
        return view('admin.user.activity-list');
    }
}
