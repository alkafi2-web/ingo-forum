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
            'dashboard-view',
            'member-list-view',
            'member-request-view',
            'member-management',
            'post-add',
            'post-view-all',
            'post-request',
            'post-management',
            'post-category-manage',
            'post-subcategory-manage',
            'publication-add',
            'publication-view-all',
            'publication-request',
            'publication-management',
            'publication-category-manage',
            'event-add',
            'event-view',
            'event-request',
            'event-management',
            'file-add',
            'file-view',
            'file-management',
            'file-category-manage',
            'file-subcategory-manage',
            'menu-manage',
            'page-add',
            'page-view-all',
            'banner-content-manage',
            'about-us-content-manage',
            'faqs-manage',
            'photo-album-manage',
            'photo-gallery-manage',
            'video-gallery-manage',
            'users-manage',
            'roles-manage',
            'contact-list-view',
            'user-activity',
            'system-settings-manage',
            'subscriber',
            'footer-content-manages'
        ];

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'admin']);
        }

        // Define roles
        $roles = [
            ['name' => 'super-admin', 'guard_name' => 'admin'],
            ['name' => 'admin', 'guard_name' => 'admin']
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate($roleData);

            // Assign permissions based on role
            switch ($role->name) {
                case 'super-admin':
                    // Assign all permissions to super-admin role
                    $allPermissions = Permission::pluck('id')->all();
                    $role->syncPermissions($allPermissions);
                    break;

                case 'admin':
                    // Assign permissions for admin role
                    $adminPermissions = Permission::pluck('id')->all(); // Assuming admin needs all permissions
                    $role->syncPermissions($adminPermissions);
                    break;
            }
        }

        // Retrieve the user by email
        $user = User::where('email', 'hello@webase.com.bd')->first();

        if ($user) {
            // Assign the super-admin role to the user
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
