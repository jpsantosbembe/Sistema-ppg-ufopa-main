<?php

namespace Database\Seeders;

use App\Models\ProgPosGrad;
use Illuminate\Database\Seeder;

class PpgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['15010015004P3', 'BIOCIÊNCIAS', 'CIÊNCIAS BIOLÓGICAS II', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15010015072P9', 'BIODIVERSIDADE', 'BIODIVERSIDADE', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['12001015038P1', 'Biodiversidade e Biotecnologia - Rede BIONORTE', 'BIOTECNOLOGIA', 'UFPA', 'UNIVERSIDADE FEDERAL DO PARÁ', 'Doutorado'],
            ['15010015073P5', 'CIÊNCIAS DA SAÚDE', 'MEDICINA I', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15010015070P6', 'CIÊNCIAS DA SOCIEDADE', 'INTERDISCIPLINAR', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15010015005P0', 'EDUCAÇÃO', 'EDUCAÇÃO', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15006018009P1', 'EDUCAÇÃO ESCOLAR INDÍGENA', 'ENSINO', 'UEPA', 'UNIVERSIDADE DO ESTADO DO PARÁ', 'Mestrado'],
            ['15001016166P8', 'EDUCAÇÃO NA AMAZÔNIA', 'EDUCAÇÃO', 'UFPA', 'UNIVERSIDADE FEDERAL DO PARÁ', 'Doutorado'],
            ['33283010001P5', 'Ensino de Física  - PROFIS', 'ASTRONOMIA / FÍSICA', 'SBF', 'SOCIEDADE BRASILEIRA DE FÍSICA', 'Mestrado'],
            ['23001011069P5', 'LETRAS', 'LINGUíSTICA E LITERATURA', 'UFRN', 'UNIVERSIDADE FEDERAL DO RIO GRANDE DO NORTE', 'Mestrado Profissional'],
            ['15010015074P1', 'LETRAS', 'LINGUíSTICA E LITERATURA', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['31075010001P2', 'Matemática em Rede Nacional', 'MATEMÁTICA / PROBABILIDADE E ESTATÍSTICA', 'SBM', 'SOCIEDADE BRASILEIRA DE MATEMÁTICA', 'Mestrado Profissional'],
            ['31102000001P6', 'PROFNIT - PROPRIEDADE INTELECTUAL E TRANSFERÊNCIA DE TECNOLOGIA PARA INOVAÇÃO', 'ADMINISTRAÇÃO PÚBLICA E DE EMPRESAS, CIÊNCIAS CONTÁBEIS E TURISMO', 'UFAL', 'UNIVERSIDADE FEDERAL DE ALAGOAS', 'Mestrado Profissional'],
            ['15010015001P4', 'Recursos aquáticos continentais amazônicos', 'BIODIVERSIDADE', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15010015002P0', 'RECURSOS NATURAIS DA AMAZÔNIA', 'CIÊNCIAS AMBIENTAIS', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15010015071P2', 'SOCIEDADE, AMBIENTE E QUALIDADE DE VIDA', 'INTERDISCIPLINAR', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Mestrado'],
            ['15010015003P7', 'Sociedade, Natureza e Desenvolvimento', 'CIÊNCIAS AMBIENTAIS', 'UFOPA', 'UNIVERSIDADE FEDERAL DO OESTE DO PARÁ', 'Doutorado'],
        ];

        foreach ($data as $item) {
            ProgPosGrad::create([
                'codigo_ppg' => $item[0],
                'nome' => $item[1],
                'area_avaliacao' => $item[2],
                'sigla_ies' => $item[3],
                'nome_ies' => $item[4],
                'nivel' => $item[5],
            ]);
        }
    }
}
