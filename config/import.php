<?php

return [
    'sheets' => [
        1 => [
            [
                'sheet_name' => 'Docentes',
                'import_class' => 'App\Imports\Worksheets\DocenteImport'
            ],
            [
                'sheet_name' => 'Pós-Doc',
                'import_class' => 'App\Imports\Worksheets\PosDocImport'
            ],
            [
                'sheet_name' => 'Participante Externo',
                'import_class' => 'App\Imports\Worksheets\ExternoImport'
            ],
            [
                'sheet_name' => 'Discentes',
                'import_class' => 'App\Imports\Worksheets\DiscenteImport'
            ],
            [
                'sheet_name' => 'Discentes - Orientadores',
                'import_class' => 'App\Imports\Worksheets\OrientacaoImport'
            ],
            [
                'sheet_name' => 'Egressos',
                'import_class' => 'App\Imports\Worksheets\EgressoImport'
            ],
            [
                'sheet_name' => 'Projetos',
                'import_class' => 'App\Imports\Worksheets\ProjetoImport'
            ],
            [
                'sheet_name' => 'Linhas de Pesquisa - Projetos',
                'import_class' => 'App\Imports\Worksheets\LinhaDePesquisaImport'
            ],
            [
                'sheet_name' => 'Projetos - Membros',
                'import_class' => 'App\Imports\Worksheets\MembroProjetoImport'
            ],
            [
                'sheet_name' => 'TCC',
                'import_class' => 'App\Imports\Worksheets\TccImport'
            ],
            [
                'sheet_name' => 'TCC - Banca',
                'import_class' => 'App\Imports\Worksheets\BancaTccImport'
            ],
            [
                'sheet_name' => 'Projetos - Financiadores',
                'import_class' => 'App\Imports\Worksheets\FinanciadorProjetoImport'
            ],
            [
                'sheet_name' => 'TCC - Financiadores',
                'import_class' => 'App\Imports\Worksheets\FinanciadoresTccImport'
            ],
            [
                'sheet_name' => 'Produções',
                'import_class' => 'App\Imports\Worksheets\ProducaoImport'
            ],
            [
                'sheet_name' => 'Produções - Autores',
                'import_class' => 'App\Imports\Worksheets\AutorProducaoImport'
            ],
            [
                'sheet_name' => 'Produções - Detalhes',
                'import_class' => 'App\Imports\Worksheets\DetalheProducaoImport'
            ],
            [
                'sheet_name' => 'Disciplinas',
                'import_class' => 'App\Imports\Worksheets\DisciplinaImport'
            ],
            [
                'sheet_name' => 'Turmas',
                'import_class' => 'App\Imports\Worksheets\TurmaImport'
            ]
        ],
        2 => [
            [
                'sheet_name' => 'Proposta',
                'import_class' => 'App\Imports\Worksheets\PropostaImport'
            ]
            // TODO: USE DURANTE O DESENVOLVIMENTO, AO FINAL MOVA PARA ALL_DATATABLE = 1
        ]
    ],
];
