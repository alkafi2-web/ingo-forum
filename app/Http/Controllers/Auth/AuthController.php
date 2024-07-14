<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

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
        $user->assignRole('admin');
        // $user->assignRole($request->input('role'));

        return response()->json(['success' => ['success' => 'User Create Successfully']]);
        return $request->all();
    }

    public function login()
    {

        if (Auth::check()) {
            // If user is authenticated, redirect to admin home with no-cache header
            return redirect()->route('dashboard');
        } else {
            // If user is not authenticated, return login view
            return view('admin.authenication.login');
        }
    }
    public function dashboard()
    {
        return view('admin.dashboard.dashborad');
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
        if (Auth::attempt($credentials)) {
            // Authentication passed, display success toastr and redirect to dashboard
            Toastr::success('You have successfully logged in!', 'Success');
            return response()->json(['redirect' => route('dashboard')], 200);
        }

        // Authentication failed
        Toastr::error('Invalid credentials, please try again.', 'Error');
        return response()->json(['errors' => ['login' => 'Invalid credentials']], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
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
        return response()->json(['success' => ['success' => 'User Update Successfully']]);
    }
}
