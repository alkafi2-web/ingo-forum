<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function activityList(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('user-activity')) {
            abort(401);
        }
        if ($request->ajax()) {
            $activities = Activity::with('user', 'member')->latest();
            // dd($activities);
            return DataTables::of($activities)
                ->addColumn('name', function ($activity) {
                    if ($activity->user_id) {
                        return '<i class="fas fa-user"></i> User: ' . ($activity->user ? $activity->user->name : 'No User');
                    }
                    return '<i class="fas fa-building"></i> Member: ' . ($activity->member ? $activity->member->organisation_name : 'No Member');
                })
                ->addColumn('ip', function ($activity) {
                    return $activity->ip_address;
                })
                ->addColumn('activity', function ($activity) {
                    return $activity->activity;
                })
                ->addColumn('device_browser', function ($activity) {
                    $agent = new Agent();
                    $agent->setUserAgent($activity->user_agent);

                    $deviceName = $agent->device();
                    $devicePlatform = $agent->platform();
                    $browserName = $agent->browser();
                    $browserVersion = $agent->version($browserName);

                    return "{$deviceName}/{$devicePlatform} - {$browserName}: {$browserVersion}";
                })
                ->addColumn('datetime', function ($activity) {
                    return $activity->created_at->format('d M Y H:i A');
                })
                ->rawColumns(['name'])
                ->make(true);
        }
        return view('admin.user.activity-list');
    }

    public function myProfile()
    {
        $user = User::where('id', Auth::guard('admin')->id())->first();
        return view('admin.my-profile.profile', compact('user'));
    }

    public function myProfileUpdate(Request $request)
    {
        
        // Define validation rules
        $rules = [
            'first-name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
        ];

        // Custom error messages
        $messages = [
            'first-name.required' => 'The name is required.',
            'first-name.string' => 'The first name must be a string.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters long.',
        ];

        // Create a validator instance and validate the data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the authenticated admin user's profile
        $user = User::where('id', Auth::guard('admin')->id())->first();
        $user->name = $request->input('first-name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); // Hash the password before saving
        if (isset($request->image)) {
            $image = $request->image;
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/profile/');
            if ($user->image && File::exists($dir . $user->image)) {
                File::delete($dir . $user->image);
            }
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $image->move($dir, $imageName);
            $user->image = $imageName;
        }
        $user->save();

        Helper::log('Update ' . $user->name . ' user own profile');
        return response()->json(['success' => ['success' => 'Profile updated successfully.']]);
    }
}
