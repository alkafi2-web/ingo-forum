<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function role(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with('permissions')->get();

            return DataTables::of($roles)
                ->addColumn('permissions', function ($role) {
                    // Access the permissions data for each role
                    $permissions = $role->permissions->pluck('name')->implode(', ');
                    return $permissions;
                })
                ->make(true);
        }
        return view('admin.role.index');
    }
}
