<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function role(Request $request)
    {
        if ($request->ajax()) {
            // Fetch roles excluding the "super admin" role
            $roles = Role::where('name', '!=', 'super-admin')->with('permissions')->get();

            return DataTables::of($roles)
                ->addColumn('permissions', function ($role) {
                    // Access the permissions data for each role
                    $permissions = $role->permissions->pluck('name')->implode(', ');
                    return $permissions;
                })
                ->make(true);
        }
        $permissions = Permission::all();
        return view('admin.role.index', compact('permissions'));
    }

    public function roleCreate(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'The role name is required.',
            'name.unique' => 'The role name must be unique.',
            'permissions.required' => 'At least one permission must be selected.',
            'permissions.array' => 'The permissions must be an array.',
            'permissions.min' => 'At least one permission must be selected.',
            'permissions.*.exists' => 'The selected permission is invalid.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $role = Role::create([
            'name' => $request->input('name'),
        ]);
        // Retrieve selected permissions from the request data
        $selectedPermissionIds = $request->input('permissions', []);

        // Retrieve Permission models based on the selected permission IDs
        $selectedPermissions = Permission::whereIn('id', $selectedPermissionIds)->get();

        // Extract permission names from Permission models
        $selectedPermissionNames = $selectedPermissions->pluck('name')->toArray();

        // Synchronize the role's permissions with the selected permission names
        $role->syncPermissions($selectedPermissionNames);
        return response()->json(['success' => ['success' => 'Role Create successfully!']]);
    }

    public function roleDelete(Request $request)
    {
        $perm = Role::where('id', $request->id)->where('name', '!=', 'admin')->where('name', '!=', 'super-admin');
        $perm->delete();
        return response()->json(['success' => 'Role deleted successfully']);
    }

    public function roleEdit(Request $request)
    {
        $perm = Role::where('id', $request->id)->with('permissions')->first();
        // return $roleHasPermissions = DB::table('role_has_permissions')->where('role_id', $request->id)->get();
        return response()->json(['perm' => $perm]);
    }

    public function roleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $request->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'name.required' => 'The role name is required.',
            'name.unique' => 'The role name must be unique.',
            'permissions.required' => 'At least one permission must be selected.',
            'permissions.array' => 'The permissions must be an array.',
            'permissions.min' => 'At least one permission must be selected.',
            'permissions.*.exists' => 'The selected permission is invalid.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $role = Role::find($request->id);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }

        // Update the role name
        $role->update([
            'name' => $request->input('name'),
        ]);

        // Retrieve selected permissions from the request data
        $selectedPermissionIds = $request->input('permissions', []);

        // Retrieve Permission models based on the selected permission IDs
        $selectedPermissions = Permission::whereIn('id', $selectedPermissionIds)->get();

        // Extract permission names from Permission models
        $selectedPermissionNames = $selectedPermissions->pluck('name')->toArray();

        // Synchronize the role's permissions with the selected permission names
        $role->syncPermissions($selectedPermissionNames);

        return response()->json(['success' => ['success' => 'Role updated successfully!']]);
    }
}
