<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        Permission::create(['name' => 'user.*.*'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'admin.*.*'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.admin.*']);
        Permission::create(['name' => 'admin.admin.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.admin.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.admin.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.admin.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.admin.edit'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.roleUsers.*']);
        Permission::create(['name' => 'admin.roleUsers.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roleUsers.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roleUsers.edit'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.ingress.*']);
        Permission::create(['name' => 'admin.ingress.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingress.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.ingress.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.operationTypes.*']);
        Permission::create(['name' => 'admin.operationTypes.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.operationTypes.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.operationTypes.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'admin.movements.*']);
        Permission::create(['name' => 'admin.movements.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.movements.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.movements.destroy'])->syncRoles([$admin]);

        Permission::create(['name' => 'user.envioBasicos.*']);
        Permission::create(['name' => 'user.envioBasicos.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioBasicos.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioBasicos.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioBasicos.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioBasicos.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'user.envioMulti.*']);
        Permission::create(['name' => 'user.envioMulti.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioMulti.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioMulti.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioMulti.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.envioMulti.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'user.emails.*']);
        Permission::create(['name' => 'user.emails.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.emails.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.emails.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.emails.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.emails.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'user.profiles.*']);
        Permission::create(['name' => 'user.profiles.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.profiles.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.profiles.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.profiles.destroy'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'user.movements.*']);
        Permission::create(['name' => 'user.movements.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.movements.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.movements.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'user.movements.destroy'])->syncRoles([$admin, $user]);

        // Permission::create(['name' => 'transfer-register.index'])->syncRoles([$admin]);
        // Permission::create(['name' => 'transfer-register.show'])->syncRoles([$admin, $user]);
    }
}
