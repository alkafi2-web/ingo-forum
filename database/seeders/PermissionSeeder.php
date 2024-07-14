<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define array of permission names
        $permissions = [
            'dashboard',
            'menu',
            'page',
            'website-content',
            'event',
            'post',
            'user',
            'role'

        ];

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName, 'guard_name' => 'admin']);
        }

        // Create roles
        $roles = [
            ['name' => 'super-admin', 'guard_name' => 'admin'],
            ['name' => 'admin', 'guard_name' => 'admin']
        ];

        foreach ($roles as $roleData) {
            $role = Role::create($roleData);

            // Assign permissions based on role
            switch ($role->name) {
                case 'super-admin':
                    // Assign all permissions to super-admin role
                    $permissions = Permission::pluck('id')->all();
                    $role->syncPermissions($permissions);
                    break;

                case 'admin':
                    // Assign permissions for admin role
                    $adminPermissions = [
                        'dashboard',
                        'menu',
                        'page',
                        'website-content',
                        'event',
                        'post',
                        'user',
                        'role'
                    ];
                    $adminPermissionsIds = Permission::whereIn('name', $adminPermissions)->pluck('id')->all();
                    $role->syncPermissions($adminPermissionsIds);
                    break;
            }
        }

        // Retrieve the user by email
        $user = User::where('email', 'hello@webase.com.bd')->first();

        if ($user) {
            // Assign the role to the user
            $role = Role::where('name', 'super-admin')->first(); // Assuming 'super-admin' role exists
            if ($role) {
                $user->assignRole($role);
                $user->update([
                    'role' => $role->name
                ]);
            } else {
                $this->command->info('Role not found');
            }
        } else {
            $this->command->info('User not found');
        }
    }
}
