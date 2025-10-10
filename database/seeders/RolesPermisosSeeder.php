<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpia la caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // Eliminar registros de tablas pivot manualmente
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_permissions')->delete();

        // Borrar roles y permisos
        Role::query()->delete();
        Permission::query()->delete();

        // Opcional: crea permisos
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver informes']);
        Permission::create(['name' => 'ver dashboard']);

        // Crear roles.
        $administrador = Role::create(['name' => 'administrador']);
        $estandar = Role::create(['name' => 'estandar']);
        $invitado = Role::create(['name' => 'invitado']);

        // Asigna permisos a roles
        $administrador->givePermissionTo(Permission::all());
        $estandar->givePermissionTo(['ver dashboard', 'ver informes']);
        $invitado->givePermissionTo('ver informes');
    }
}
