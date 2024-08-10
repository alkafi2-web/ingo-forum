<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncNewPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:newPermission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create permissions
        $permissionNames = [
            'voter-slip-print',
            'print-voter-info',
            'print-program-single-info',
        ];

        foreach ($permissionNames as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Get all permissions
        $permissions = Permission::all();

        // Get the super-admin role
        $superAdminRole = Role::where('name', 'super-admin')->first();

        // Sync all permissions to the super-admin role
        $superAdminRole->syncPermissions($permissions);

        // Get the admin role
        $adminRole = Role::where('name', 'admin')->first();

        // Assign the new permissions to the role
        foreach ($permissionNames as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission && !$adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission);
            }
        }
        $this->info('New permission sync successfully');
    }
}
