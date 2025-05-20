<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Categoria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        for($i=1;$i<=20;$i++){
            Categoria::create(
                [
                    'nombre' => "Categoría $i",
                ]
            );
        }
    }
}
