<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Seed the application's database with categories.
     */
    public function run(): void
    {
        $categorias = [
            ['categoria' => 'Eletrônicos'],
            ['categoria' => 'Móveis'],
            ['categoria' => 'Vestuário'],
            ['categoria' => 'Esportes'],
            ['categoria' => 'Livros'],
            ['categoria' => 'Brinquedos'],
            ['categoria' => 'Ferramentas'],
            ['categoria' => 'Alimentos'],
            ['categoria' => 'Bebidas'],
            ['categoria' => 'Automotivo'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
