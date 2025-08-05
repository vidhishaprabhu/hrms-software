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
    $employeeRole = Role::firstOrCreate(['name' => 'employee']);
    $hrrole = Role::firstOrCreate(['name' => 'hr']);

    // Create permissions
    $applyLeavePermission = Permission::firstOrCreate(['name' => 'apply leave']);
    $viewLeaveStatusPermission = Permission::firstOrCreate(['name' => 'view leave status']);

    // Assign permissions to roles
    $adminRole->givePermissionTo([$applyLeavePermission, $viewLeaveStatusPermission]);
    $employeeRole->givePermissionTo([$applyLeavePermission]);
     $hrrole->givePermissionTo([$viewLeaveStatusPermission]);

    // Assign role to Admin (e.g. user ID = 1)
    $admin = User::find(1);
    if ($admin) {
        $admin->assignRole($adminRole);
    }

    // Assign role to Employees (e.g. user ID = 2 and 3)
    $employee1 = User::find(4);
    $employee2 = User::find(5);
    $employee3 = User::find(6);
    
    if ($employee3) {
        $employee3->assignRole($hrrole);
    }

    if ($employee1) {
        $employee1->assignRole($employeeRole);
    }

    if ($employee2) {
        $employee2->assignRole($employeeRole);
    }
    }
}
