<?php

namespace Database\Seeders;

use App\Models\BancaTcc;
use App\Models\Categoria;
use App\Models\ResponsavelTurma;
use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['categorias', 'Categoria'],
            ['categorias_docentes', 'CategoriaDocente'],
            ['orientacoes', 'Orientacoes'],
            ['pessoas', 'Pessoas'],
            ['ppgs', 'ProgPosGrad'],
            ['vinculos', 'Vinculos'],
            ['vinculos_discentes', 'VinculosDiscentes'],
            ['vinculos_docentes', 'VinculosDocentes'],
            ['vinculos_externos', 'VinculoExterno'],
            ['vinculos_pos_doc', 'VinculoPosDoc'],
            ['vinculos_egressos', 'VinculoEgresso'],
            ['linhas_de_pesquisas', 'LinhaDePesquisa'],
            ['area_de_concentracaos', 'AreaDeConcentracao'],
            ['projetos', 'Projeto'],
            ['linhas_projetos', 'LinhaProjeto'],
            ['membros_projetos', 'Membro_Projeto'],
            ['tccs', 'Tcc'],
            ['banca_tccs', 'BancaTcc'],
            ['financiadores', 'Financiador'],
            ['financiadores_projetos', 'FinanciadoProjeto'],
            ['financiadores_tccs', 'FinanciadoresTcc'],
            ['producoes','Producao'],
            ['tipos_producoes','TipoProducao'],
            ['subtipos_producoes','SubTipoProducao'],
            ['autores_producoes','AutorProducao'],
            ['detalhes_producoes','DetalheProducao'],
            ['nivel_cursos', 'NivelCurso'],
            ['cursos', 'Curso'],
            ['disciplinas', 'Disciplina'],
            ['disciplina_acs', 'DisciplinaAc'],
            ['turmas', 'Turma'],
            ['responsavel_turmas','ResponsavelTurma'],
            ['coletas', 'Coleta'],
            ['quesitos', 'Quesito'],
            ['items', 'Item'],
            ['pessoa_images', 'PessoaImages']
        ];

        foreach ($data as $item) {
            Table::create([
               'name' => $item[0],
               'model' => $item[1]
            ]);
        }
    }
}
