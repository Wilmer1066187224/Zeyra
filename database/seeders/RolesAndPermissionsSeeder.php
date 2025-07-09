<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia cache de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crea permisos
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'eliminar productos']);

        // Crea roles
        $admin = Role::create(['name' => 'admin']);
        $vendedor = Role::create(['name' => 'vendedor']);

        // Asigna permisos a roles
        $admin->givePermissionTo(['ver productos', 'crear productos', 'eliminar productos']);
        $vendedor->givePermissionTo(['ver productos']);
    }
}
