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

        Permission::create(['name' => 'home'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'admin.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.edit'])->syncRoles([$admin]);

        Permission::create(['name' => 'envioBasico.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'envioBasico.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'envioBasico.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'envioBasico.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'envioBasico.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'address.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'address.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'address.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'address.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'address.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'creditCard.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'creditCard.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'creditCard.show'])->syncRoles([$admin], $user);
        Permission::create(['name' => 'creditCard.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'creditCard.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'email.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'email.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'email.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'email.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'email.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'phone.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'phone.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'phone.show'])->syncRoles([$admin], $user);
        Permission::create(['name' => 'phone.destroy'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'phone.edit'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'profile.index'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'profile.create'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'profile.show'])->syncRoles([$admin, $user]);
        Permission::create(['name' => 'profile.destroy'])->syncRoles([$admin, $user]);

        Permission::create(['name' => 'transfer-register.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'transfer-register.show'])->syncRoles([$admin, $user]);
    }
}
