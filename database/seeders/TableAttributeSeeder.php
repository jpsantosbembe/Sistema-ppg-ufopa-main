<?php

namespace Database\Seeders;

use App\Models\TableAttribute;
use Illuminate\Database\Seeder;

class TableAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Tabela categoria_docentes
            ['id_vinculo_docente', 'int', 'id_vinculo_docente', 'id_vinculo_docente', true, 2],
            ['id_categoria', 'int', 'id_categoria', 'id_categoria', true, 2],
            ['data_inicio', 'date', 'inicio_da_categoria', 'Data de início', true, 2],
            ['data_fim', 'date', 'fim_da_categoria', 'Data de Final', true, 2],
            ['ch', 'int', 'carga_horaria_pg_semanal', 'CH', true, 2],
            ['ativo', 'boolean', 'ativo', 'ativo', true, 2],

            // Tabela orientacoes
            ['id_vinculo_discente', 'int', 'id_vinculo_discente', 'id_vinculo_discente', true, 3],
            ['id_orientador', 'int', 'id_orientador', 'id_orientador', true, 3],
            ['data_inicio', 'date', 'inicio_da_orientacao', 'Inicio da orientação', true, 3],
            ['data_fim', 'date', 'fim_da_orientacao', 'Fim da orientação', true, 3],
            ['principal', 'boolean', 'orientador_principal', 'Orientador principal', true, 3],

            // Table pessoas
            ['codigo_pessoa', 'int', 'identificador_da_pessoa', 'ID', true, 4],
            ['nome', 'string', 'nome_pessoa', 'Nome', true, 4],
            ['tipo_doc', 'string', 'tipo_de_documento', 'Tipo de documento', true, 4],
            ['doc', 'string', 'numero_do_documento', 'Numero do documento', true, 4],
            ['nacionalidade', 'string', 'nacionalidade', 'Nacionalidade', true, 4],
            ['pais', 'string', 'pais', 'País', true, 4],
            ['orcid', 'string', 'orcid', 'orcid', true, 4],
            ['lattes', 'string', 'numero_do_curriculo_lattes', 'orcid', true, 4],
            ['data_nascimento', 'date', 'data_de_nascimento', 'Data de nascimento', true, 4],
            ['email', 'string', 'e_mail', 'email', true, 4],
            ['abreviatura', 'string', 'abreviatura', 'Abreviatura', true, 4],
            ['incompleto', 'boolean', 'incompleto', 'Cadastro Incompleto', true, 4],

            // Table ppgs
            ['codigo_ppg', 'int', 'codigo_do_ppg', 'Código do PPG', true, 5],
            ['nome', 'string', 'nome_do_ppg', 'Nome', true, 5],
            ['area_avaliacao', 'string', 'area_de_avaliacao', 'Nome', true, 5],
            ['sigla_ies', 'string', 'ies_sigla', 'Nome', true, 5],
            ['nome_ies', 'string', 'ies_nome', 'Nome', true, 5],

            // Table vinculos
            ['id_pessoa', 'int', 'id_pessoa', 'id_pessoa', true, 6],
            ['id_ppg', 'int', 'id_ppg', 'id_ppg', true, 6],

            // Table vinculos_discentes
            ['codigo_vinculavel', 'int', 'identificador_do_discente', 'Identificador do Discente', true, 7],
            ['genero', 'string', 'genero', 'Gênero', true, 7],
            ['raca_cor', 'string', 'racacor', 'Raça/Cor', true, 7],
            ['portador_deficiencia', 'boolean', 'portador_de_deficiencia', 'Portador de Deficiência', true, 7],
            ['nivel', 'string', 'nivel_discente', 'Nível do Discente', true, 7],
            ['situacao', 'string', 'situacao_discente', 'Situação do Discente', true, 7],
            ['data_inicio', 'date', 'data_matricula', 'Data da Matrícula', true, 7],
            ['data_situacao', 'date', 'data_situacao', 'Data da Situação', true, 7],

            // Table vinculos_docentes
            ['codigo_vinculavel', 'int', 'identificador_do_docente', 'Identificador do Docente', true, 8],
            ['codigo_lattes', 'string', 'numero_do_curriculo_lattes', 'Número do currículo Lattes', true, 8],
            ['sigla_ies', 'string', 'ies_sigla_do_docente', 'Sigla da IES', true, 8],
            ['nome_ies', 'string', 'ies_nome_do_docente', 'Nome da IES', true, 8],
            ['nivel_titulacao', 'string', 'titulacao', 'Titulação', true, 8],
            ['ano_tit', 'int', 'ano_titulacao', 'Ano  da titulação', true, 8],
            ['area_conhecimento_tit', 'string', 'area_de_conhecimento_titulacao', 'Área de conhecimento', true, 8],
            ['pais_ies_tit', 'string', 'pais_da_ies_da_titulacao', 'País da IES', true, 8],
            ['sigla_ies_tit', 'string', 'ies_sigla_da_titulacao', 'Sigla da IES', true, 8],
            ['nome_ies_tit', 'string', 'ies_nome_da_titulacao', 'Nome da IES', true, 8],
            ['regime_trabalho', 'string', 'regime_de_trabalho', 'Regime de trabalho', true, 8],
            ['data_inicio', 'date', 'data_de_admissao', 'Data de admissão', true, 8],
            ['data_fim', 'date', 'data_de_desligamento', 'Data de desligamento', true, 8],

            // Table vinculos_externos
            ['codigo_vinculavel', 'int', 'identificador_do_participante', 'Identificador do Participante', true, 9],
            ['genero', 'string', 'genero', 'Gênero', true, 9],
            ['pais_ies_orig', 'string', 'pais_da_instituicao_de_origem', 'País da Instituição de Origem', true, 9],
            ['nome_ies_orig', 'string', 'instituicao_de_origem', 'Instituição de Origem', true, 9],
            ['tipo_participacao', 'string', 'tipos_de_participacao', 'Tipos de Participação', true, 9],
            ['nivel_titulacao', 'string', 'nivel_titulacao', 'Nível Titulação', true, 9],
            ['area_conhecimento_tit', 'string', 'area_de_conhecimento_titulacao', 'Área de Conhecimento Titulação', true, 9],
            ['pais_ies_tit', 'string', 'pais_titulacao', 'País Titulação', true, 9],
            ['nome_ies_tit', 'string', 'nome_ies_titulacao', 'Nome IES Titulação', true, 9],
            ['data_inicio', 'string', 'ano_titulacao', 'Ano  da titulação', true, 9],

            // Table vinculos_posdocs
            ['codigo_vinculavel', 'int', 'identificador_do_pos_doc', 'Identificador do Pós-Doc', true, 10],
            ['genero', 'string', 'genero', 'Gênero', true, 10],
            ['sigla_ies', 'string', 'pos_doc_ies_sigla', 'Pós-Doc IES Sigla', true, 10],
            ['nome_ies', 'string', 'pos_doc_ies_nome', 'Pós-Doc IES Nome', true, 10],
            ['data_inicio', 'date', 'vinculo_inicio', 'Vínculo início', true, 10],
            ['data_fim', 'date', 'vinculo_fim', 'Vínculo Fim', true, 10],
            ['sigla_ies_orig', 'string', 'origem_ies_sigla', 'Origem IES Sigla', true, 10],
            ['nome_ies_orig', 'string', 'origem_ies_nome', 'Origem IES Nome', true, 10],
            ['nivel_titulacao', 'string', 'titulacao_nivel', 'Nível Titulação', true, 10],
            ['ano_tit', 'string', 'titulacao_ano', 'Ano  da titulação', true, 10],
            ['area_conhecimento_tit', 'string', 'titulacao_area', 'Área de Conhecimento Titulação', true, 10],
            ['sigla_ies_tit', 'string', 'titulacao_ies_sigla', 'Sigla IES Titulação', true, 10],
            ['nome_ies_tit', 'string', 'titulacao_ies_nome', 'Nome IES Titulação', true, 10],
            ['pais_ies_tit', 'string', 'titulacao_pais', 'País Titulação', true, 10],

            // Table vinculos_egressos
            ['codigo_vinculavel', 'int', 'identificador_do_egresso', 'Identificador do Egresso', true, 11],
            ['genero', 'string', 'genero', 'Gênero', true, 11],
            ['nivel_titulacao', 'string', 'nivel_titulacao', 'Nível Titulação', true, 11],
            ['area_conhecimento_tit', 'string', 'area_de_conhecimento_titulacao', 'Área de Conhecimento Titulação', true, 11],
            ['pais_ies_tit', 'string', 'pais_titulacao', 'País Titulação', true, 11],
            ['sigla_ies_tit', 'string', 'sigla_ies_titulacao', 'Sigla IES Titulação', true, 11],
            ['nome_ies_tit', 'string', 'nome_ies_titulacao', 'Nome IES Titulação', true, 11],
            ['data_inicio', 'string', 'ano_titulacao', 'Ano  da titulação', true, 11],

            // Table linha_de_pesquisas
            ['id_ppg', 'int', 'id_ppg', 'id_ppg', true, 12],
            ['codigo_lp', 'int', 'identificador_da_linha_de_pesquisa', 'codigo_lp', true, 12],
            ['nome', 'string', 'linha_de_pesquisa', 'Linha de Pesquisa', true, 12],
            ['data_inicio', 'date', 'data_de_inicio_da_linha', 'Data de início', true, 12],
            ['data_fim', 'date', 'data_de_fim_da_linha', 'Data de Final', true, 12],
            ['id_ac', 'int', 'id_ac', 'id_ac', true, 12],

            // Table area_de_concentracaos
            ['codigo_ac', 'int', 'identificador_da_area_de_concentracao', 'codigo_ac', true, 13],
            ['nome', 'string', 'area_de_concentracao', 'Área de Concentração', true, 13],

            // Table projetos
            ['id_ppg', 'int', 'id_ppg', 'id_ppg', true, 14],
            ['codigo_projeto', 'int', 'identificador_do_projeto_de_pesquisa', 'codigo_projeto', true, 14],
            ['id_ac', 'int', 'id_ac', 'id_ac', true, 14],
            ['nome', 'string', 'nome_do_projeto_de_pesquisa', 'Nome do Projeto de Pesquisa', true, 14],
            ['natureza_projeto', 'string', 'natureza_do_projeto_de_pesquisa', 'Natureza do Projeto de Pesquisa', true, 14],
            ['situacao', 'string', 'situacao', 'Situação', true, 14],
            ['data_situacao', 'date', 'data_da_situacao', 'Data da Situação', true, 14],
            ['data_inicio', 'date', 'data_de_inicio', 'Data de início', true, 14],
            ['tem_membro_cad', 'boolean', 'tem_membro_cad', 'Tem membro cadastrado', true, 14],

            // Table linha_projetos
            ['id_projeto','int','id_projeto','id_projeto',true,15],
            ['id_lp','int','id_lp','id_lp',true,15],
            ['data_inicio','date','data_de_inicio_do_vinculo_com_a_linha', 'Data de Início do Vínculo com a Linha',true,15],

            // Table membros_projetos
            ['id_projeto','int','id_projeto','id_projeto',true,16],
            ['id_pessoa','int','id_pessoa','id_pessoa',true,16],
            ['membro_responsavel','boolean','membro_responsavel', 'Membro Responsável',true,16],
            ['categoria','string','categoria_do_membro_do_projeto', 'Categoria',true,16],
            ['data_inicio', 'date', 'data_inicio_do_membro', 'Data de início', true, 16],
            ['data_fim', 'date', 'data_fim_do_membro', 'Data de Final', true, 16],
            ['vinculo_id','int','vinculo_id','vinculo_id',true,16],

            //Table tccs
            ['nome', 'string', 'nome_do_trabalho_de_conclusao', 'nome', true, 17],
            ['id_ppg', 'int', 'codigo_do_ppg', 'codigo_do_ppg', true, 17],
            ['codigo_tcc', 'int', 'identificador_do_trabalho_de_conclusao', 'Código TCC' ,  true, 17],
            ['id_linha', 'int', 'id_linha', 'id_linha', true, 17],
            ['id_tipo', 'int', 'id_tipo', 'Tipo', true, 17],
            ['id_ac', 'int', 'id_ac', 'id_ac', true, 17],
            ['id_projeto', 'int', 'id_projeto', 'id_projeto', true, 17],
            ['id_autor', 'int', 'id_autor', 'id_autor', true, 17],
            ['id_orientador', 'int', 'id_orientador', 'id_orientador', true, 17],
            ['data_defesa', 'date', 'data_da_defesa', 'data_defesa' ,true, 17],
            ['data_inicio', 'date', 'data_inicio_da_orientacao', 'data_inicio',true, 17],
            ['data_fim', 'date', 'data_fim_da_orientacao', 'data_fim',true, 17],

            // Table banca_tccs
            ['id_tcc', 'int', 'id_tcc', 'ID Tcc', true, 18],
            ['id_pessoa_banca', 'int', 'id_pessoa_banca', 'Pessoa da Banca', true,18],
            ['id_orientador', 'int', 'id_orientador', 'id_orientador', true, 18],

            // Table financiadores
            ['tipo_doc','string','tipo_de_documento_do_financiador','Tipo de Documento do Financiador',true,19],
            ['doc','string','documento_do_financiador','Documento do Financiador',true,19],
            ['estrangeiro','boolean','financiador_estrangeiro', 'Financiador Estrangeiro',true,19],
            ['nome','string','nome_do_financiador','Nome do Financiador',true,19],

            // Table financiadores_projetos
            ['id_projeto','int','id_projeto','ID Projeto',true,20],
            ['id_financiador','int','id_financiador','ID Fornecedor',true,20],
            ['natureza','string','natureza_do_financiador','Natureza do Financiador',true,20],
            ['data_inicio','date','data_inicio_financiador','data_inicio',true,20],
            ['data_fim','date','data_fim_financiador', 'data_fim',true,20],

            // Table financiadores_tccs
            ['id_financiador', 'int', 'id_financiador', 'ID Financiandor', true, 21],
            ['id_tcc', 'int', 'id_tcc', 'ID TCC', true, 21],
            ['nome_prog_fomento', 'string','nome_do_programa_de_fomento', 'Nome do Programa de Fomento', true, 21],
            ['qtd_meses', 'int', 'quantidade_de_meses', 'Quantidade de Meses', true, 21],

            // Table producoes
            ['id_ppg', 'int', 'id_ppg', 'id_ppg', true, 22],
            ['id_lp','int','id_lp','ID Linha de pesquisa',true, 22],
            ['id_projeto','int','id_projeto','ID Projeto',true, 22],
            ['id_tipo', 'int', 'id_tipo', 'ID Tipo de Produção', true, 22],
            ['id_subtipo', 'int', 'id_subtipo', 'ID Subtipo de Produção', true, 22],
            ['codigo_producao', 'int', 'id_da_producao', 'Código Produção', true, 22],
            ['id_contexto', 'int', 'id_contexto', 'ID Contexto', true, 22],
            ['nome', 'string', 'nome_da_producao', 'Nome da Produção', true, 22],
            ['ano_publicacao', 'string', 'ano_da_producao', 'Ano da Produção', true, 22],
            ['issn', 'string', 'issn', 'issn', true, 22],
            ['estrato', 'string', 'estrato', 'estrato', true, 22],
            ['cinco_mais_relevante', 'boolean', 'entre_as_5_producoes_mais_relevantes_do_programa', 'Entre as 5 produções mais relevantes do programa?', true, 22],

            // Table tipo_producaos
            ['nome','string','tipo_de_producao','Tipo de Produção',true,23],

            // Table subtipo_producaos
            ['nome','string','subtipo_de_producao','Subtipo de Produção',true,24],

            // Table autor_producaos
            ['id_producao','int','id_producao','ID Produção',true,25],
            ['id_pessoa','int','id_pessoa','ID Pessoa',true,25],
            ['categoria','string','categoria_do_autor','Categoria da pessoa',true,25],
            ['nome_autor', 'string', 'nome_autor', 'Nome do Autor', true, 25],
            ['ordem','int','numero_de_ordem_do_autor','Número de Ordem do Autor',true,25],

            // Table detalhe_producaos
            ['id_producao','int','id_producao','ID Produção',true,26],
            ['item','string','item_de_detalhamento','Item de Detalhamento',true,26],
            ['valor_item','int','valor_do_item_de_detalhamento','Valor do Item de Detalhamento',true,26],

            //Table nivel_cursos
            ['tipo', 'string', 'nivel_do_curso','Nível do Curso', true, 27],

            //Table cursos
            ['codigo_curso', 'string', 'codigo_do_curso','Código do Curso', true, 28],
            ['nome', 'string', 'nome_do_curso', 'Nome do Curso', true, 28],
            ['id_ppg', 'int', 'id_ppg', 'id_ppg', true, 28],
            ['id_nivel', 'int', 'id_nivel', 'id_nivel', true, 28],

            //Table disciplinas
            ['codigo_disciplina', 'int', 'id_da_disciplina', 'ID da Disciplina', true, 29],
            ['nome', 'string', 'nome_da_disciplina', 'Nome da Disciplina', true, 29],
            ['sigla', 'string', 'sigla_da_disciplina', 'Sigla da Disciplina', true, 29],
            ['data_inicio', 'date', 'data_de_inicio', 'Data de início', true, 29],
            ['data_fim', 'date', 'data_de_fim', 'Data de fim', true, 29],
            ['indicador_obrigatoria', 'boolean', 'indicadora_de_disciplina_obrigatoria', 'Indicadora de disciplina obrigatória', true, 29],
            ['qtd_creditos', 'int', 'quantidade_de_creditos', 'Quantidade de créditos', true, 29],
            ['numero', 'int', 'numero_da_disciplina', 'Número da Disciplina', true, 29],
            ['ch', 'int', 'carga_horaria','Carga Horária', true, 29],
            ['id_curso', 'int', 'id_curso', 'id_curso', true, 29],

            //Table disciplina_acs
            ['id_disciplina', 'int', 'id_disciplina', 'id_disciplina', true, 30],
            ['id_ac', 'int', 'id_ac', 'id_ac', true, 30],

            //Table turmas
            ['codigo_turma', 'int', 'identificador_da_turma','Identificador da Turma', true, 31],
            ['nome', 'string', 'nome_da_turma', 'Nome da Turma', true, 31],
            ['periodoAno', 'string', 'periodoano' ,'Período/Ano', true, 31],
            ['id_disciplina', 'int', 'id_disciplina', 'id_disciplina', true, 31],

            //Table responsavel_turmas
            ['indicador_resp_principal', 'boolean', 'indicador_de_responsavel_principal', 'Indicador de responsável principal', true, 32],
            ['id_pessoa', 'int', 'id_pessoa', 'id_pessoa' , true, 32],
            ['id_turma', 'int', 'id_turma', 'id_turma', true, 32],

            //coletas
            ['data_envio', 'date', 'data_hora_do_envio', 'Data e Hora de envio', true, 33],
            ['id_ppg', 'int', 'id_ppg', 'Codigo PPG', true, 33],
            ['ano_calendario', 'int','ano_do_calendario' , 'Ano Calendário', true, 33],

            // Quesitos
            ['id_coleta', 'int', 'id_coleta', 'id coleta', true, 34],
            ['nome', 'string', 'quesito', 'Quesito',true, 34],

           // Item
            ['nome', 'string', 'item', 'Nome item',true, 35],
            ['conteudo', 'string', 'conteudo', 'Conteudo',true, 35],
            ['id_quesito', 'int', 'id_quesito', 'Quesito', true, 35],

            // PessoaImages
            ['id_pessoa', 'string', 'id_pessoa', 'ID Pessoa',true, 36],
            ['path', 'string', 'path', 'Image',true, 36],
        ];

        foreach ($data as $item) {
            TableAttribute::create([
                'name' => $item[0],
                'type' => $item[1],
                'column' => $item[2],
                'front_name' => $item[3],
                'fillable' => $item[4],
                'table_id' => $item[5],
            ]);
        }
    }
}
