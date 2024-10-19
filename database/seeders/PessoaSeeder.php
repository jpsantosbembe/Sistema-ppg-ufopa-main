<?php

namespace Database\Seeders;

use App\Models\Pessoa;
use Illuminate\Database\Seeder;

class PessoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pessoa = Pessoa::create([
            'id' => 0,
            'codigo_pessoa' => 0,
            'nome' => 'Pessoa sem cadastro',
            'incompleto' => true,
        ]);

        $pessoa->id = 0;
        $pessoa->save();
    }
}
