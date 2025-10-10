<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        $this->call(CategoriaSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(RolesPermisosSeeder::class); // Se debe ejecutar antes de UserSeeder
        $this->call(UserSeeder::class); // Se debe ejecutar después de Roles y Permisos
    }
}
