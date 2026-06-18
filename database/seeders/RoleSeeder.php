<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saRole = Role::create(['name' => 'Super Admin']);
        $aRole = Role::create(['name' => 'Admin']);
        $sRole = Role::create(['name' => 'Student']);
        $cRole = Role::create(['name' => 'Client']);
        $saPermission = Permission::create(['name' => 'super-admin-permission']);
        $aPermission = Permission::create(['name' => 'admin-permission']);
        $sPermission = Permission::create(['name' => 'student-permission']);
        $cPermission = Permission::create(['name' => 'client-permission']);

        $saRole->givePermissionTo($saPermission);
        $aRole->givePermissionTo($aPermission);
        $sRole->givePermissionTo($sPermission);
        $cRole->givePermissionTo($cPermission);

        $saPermission->assignRole($saRole);
        $aPermission->assignRole($aRole);
        $sPermission->assignRole($sRole);
        $cPermission->assignRole($cRole);
    }
}
