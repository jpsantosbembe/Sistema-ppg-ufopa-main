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
        $this->call(UserRolesSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(PpgSeeder::class);
        $this->call(PessoaSeeder::class);
        $this->call(TableSeeder::class);
        $this->call(TableAttributeSeeder::class);
        $this->call(UserSeeder::class);
//        $this->call(QualisSeeder::class);
    }
}
