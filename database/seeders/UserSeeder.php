<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario Administrador
        $admin = User::Create(
            [
                'email' => 'mcortez_vasquez@yahoo.com',
                'name' => 'Miguel Cortez',
                'password' => Hash::make('Qdm.XYZ99'),
            ]
        );
        $admin->assignRole('administrador');
        // Crear usuario Estandar
        $estandar = User::Create(
            [
                'email' => 'mcortez_vasquez@hotmail.com',
                'name' => 'Miguel Cortez',
                'password' => Hash::make('Qdm.XYZ99'),
            ]
        );
        $estandar->assignRole('estandar');
        // Crear usuario Estandar
        $invitado = User::Create(
            ['email' => 'macv.sv@gmail.com',
                'name' => 'Miguel Cortez',
                'password' => Hash::make('Qdm.XYZ99'),
            ]
        );
        $invitado->assignRole('invitado');
    }
}
