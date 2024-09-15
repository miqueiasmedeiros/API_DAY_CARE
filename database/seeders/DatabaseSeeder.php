<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategoriaSeeder::class); // Chama o seeder de categorias
        $this->call(ProdutoSeeder::class);   // Chama o seeder de produtos
    }
}
