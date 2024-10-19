<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = env('QUALIS_PATH');

        DB::statement('
            CREATE TEMPORARY TABLE temp_qualis (
                id INT AUTO_INCREMENT PRIMARY KEY,
                issn VARCHAR(255),
                titulo VARCHAR(255),
                area_de_avaliacao VARCHAR(255),
                estratos VARCHAR(255)
            )
        ');

        DB::statement("LOAD DATA INFILE '$path'
                       INTO TABLE temp_qualis
                       FIELDS TERMINATED BY ','
                       ENCLOSED BY '\"'
                       LINES TERMINATED BY '\n'
                       IGNORE 1 ROWS
                       (issn, titulo, area_de_avaliacao, estratos)");

        DB::statement("INSERT INTO qualis (issn, titulo, area_de_avaliacao, estratos)
                       SELECT issn, titulo, area_de_avaliacao, estratos
                       FROM temp_qualis
                       ON DUPLICATE KEY UPDATE
                       titulo = VALUES(titulo),
                       area_de_avaliacao = VALUES(area_de_avaliacao),
                       estratos = VALUES(estratos)");
    }
}
