<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\Producto;
use Faker\Factory as Faker;
class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->faker = Faker::create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Producto::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        for($i=1;$i<=500;$i++){
            $categoria = Categoria::inRandomOrder()->first();
            Producto::create(
                [
                    'nombre' => "Producto $i",
                    'stock' => $this->faker->randomNumber(3),
                    'precio' => $this->faker->randomFloat(2,1,500),
                    'categoria_id' => $categoria->id
                ]
            );
        }
    }
}
