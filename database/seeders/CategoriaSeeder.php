<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'PERMANENTE',
            'COLABORADOR',
            'VISITANTE',
        ];

        foreach ($data as $item) {
            Categoria::create([
                'nome' => $item,
            ]);
        }

    }
}
