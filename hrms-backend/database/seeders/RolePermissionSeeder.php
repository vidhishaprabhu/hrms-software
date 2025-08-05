<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create permission
        $applyLeavePermission = Permission::firstOrCreate(['name' => 'apply leave']);

        // Assign permission to role
        $adminRole->givePermissionTo($applyLeavePermission);

        // Assign role to user (e.g. user with ID = 1)
        $user = User::find(1);
        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
