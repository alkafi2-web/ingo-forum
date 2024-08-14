<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Custom messages
        $messages = [
            'first-name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'own-password.required' => 'The own password field is required.',
            'own-password.same' => 'The passwords do not match.',
            'own-password.current_password' => 'The provided password does not match your current password.',
            'role.required' => 'The role field is required.',
        ];

        // Validation
        $validator = Validator::make($request->all(), [
            'first-name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'own-password' => ['required', 'string', 'min:6', 'current_password'],
            'role' => 'required|string', // Adjust roles as needed
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Create the user
        $user = User::create([
            'name' => $request->input('first-name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'), // Save the role
        ]);
        // $user->assignRole('admin');
        $user->assignRole($request->input('role'));
        Helper::log('Create ' . $user->name . ' user');
        return response()->json(['success' => ['success' => 'User Create Successfully']]);
    }

    public function login()
    {

        if (Auth::guard('admin')->check()) {
            // If user is authenticated, redirect to admin home with no-cache header
            return redirect()->route('dashboard');
        } else {
            // If user is not authenticated, return login view
            return view('admin.authenication.login');
        }
    }
    public function loginPost(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed for the 'admin' guard
            $user = Auth::guard('admin')->user();

            // Check if the user status is 1
            if ($user->status == 0) {
                // Log the user out and return an error response
                Auth::guard('admin')->logout();
                Toastr::error('Your account is not active. Please contact support.', 'Error');
                return response()->json(['errors' => ['login' => 'Your account is not active.']], 403);
            }

            // Update last activity time and save
            $user->last_activity = Carbon::now();
            $user->save();

            // Log the action and return success response
            Helper::log('Logged in');
            Toastr::success('You have successfully logged in!', 'Success');
            return response()->json(['redirect' => route('dashboard')], 200);
        }

        // Authentication failed
        Toastr::error('Invalid credentials, please try again.', 'Error');
        return response()->json(['errors' => ['login' => 'Invalid credentials']], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $user->last_activity = null;
        $user->save();

        Helper::log('Logged out');
        Auth::guard('admin')->logout();

        // For API routes, return a JSON response
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        // For web routes, redirect back to login or any other route
        Toastr::success('You have successfully Log out!', 'Success');
        return redirect()->route('login');
    }

    public function createUser(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('users-manage')) {
            abort(401);
        }
        if ($request->ajax()) {
            $users = User::where('role', '!=', 'super-admin')->latest()->get(); // Filter users by role

            return DataTables::of($users)
                ->make(true);
        }
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return view('admin.user.create-user', compact('roles'));
    }

    public function userStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $user = User::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $user->status = $newStatus;

        // Save the changes to the database
        $user->save();
        $statusMessage = $newStatus == 1 ? "$user->name's status changed deactive to active" : "$user->name's status changed active to deactive";
        Helper::log($statusMessage);
        return response()->json(['success' => 'User status updated successfully']);
    }

    public function userEdit(Request $request)
    {
        $user = User::findOrFail($request->id);

        return response()->json(['user' => $user]);
    }

    public function userUpdate(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id', // Ensure the ID exists in the users table
            'first-name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:6', // Optional password update
            'own-password' => ['nullable', 'string', 'min:6', 'current_password'], // Optional current password validation
            'role' => 'required|string', // Adjust roles as needed
        ], [
            'email.unique' => 'The email has already been taken.',
            'own-password.current_password' => 'The provided password does not match your current password.',
        ]);

        // If validation fails, return JSON response with errors
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $user = User::findOrFail($request->id);
        // Update user data using mass assignment
        $user->update([
            'name' => $request->input('first-name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        // Sync roles (replace existing roles with the new roles)
        $user->syncRoles([$request->input('role')]);
        Helper::log("Update $user->name's information");
        return response()->json(['success' => ['success' => 'User Update Successfully']]);
    }

    public function userDelete(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = 0; // Example update
        $user->save();
        $user->delete();
        Helper::log("Delete $user->name user");
        return response()->json(['success' => 'User Delete Successfully']);
    }

    public function trashedUser()
    {
        $users = User::onlyTrashed()->get(); // Filter users by role

        return DataTables::of($users)
            ->make(true);
    }
    public function userRestore(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        $user->restore();
        return response()->json(['success' => 'User Restore Successfully']);
    }

    public function userParDelete(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        $user->forceDelete();
        return response()->json(['success' => 'User Permanent Delete Successfully']);
    }
}
