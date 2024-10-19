<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Imports\Concerns\DateFormatChanger;
use App\Models\Financiador;
use App\Models\FinanciadorProjeto;
use App\Models\Projeto;
use App\Models\Upload;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class FinanciadorProjetoImport extends AbstractImport
{
    use DateFormatChanger;
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }
    function getLabelToLog(): string
    {
        return 'Financiador Projeto';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            // Verificar se existe o projeto
            $projeto = Projeto::where('codigo_projeto', $row['identificador_do_projeto_de_pesquisa'])->first();
            if(!$projeto){
                $this->log_error($row_index, "Projeto '{$row['nome_do_projeto_de_pesquisa']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Projeto '{$row['nome_do_projeto_de_pesquisa']}' não cadastrado");
            }

            // Verifica se exite o financiador
            $financiador = Financiador::where('doc', $row['documento_do_financiador'])->first();
            if(!$financiador){
                // Cria um novo se não existir
                $financiador = new Financiador();
            }
            // Inserir ou atualizar
            $this->fillAndSave($financiador,$row,$row_index);

            // Preparar par cria FinanciadoresProjetos
            $financiador_projeto = FinanciadorProjeto::where([
                ['id_projeto', $projeto->id],
                ['natureza',$row['natureza_do_financiador']],
                ['id_financiador',$financiador->id],
                ['data_inicio',$this->changeDateFormat($row['data_inicio_financiador'])]
            ])->first();

            if(!$financiador_projeto){
                $financiador_projeto = new FinanciadorProjeto();
                $this->log_info($row_index, "I", "Financiador Projeto: " . $financiador_projeto->id);
                $this->incNewRecordCount();
            }

            // Criar Financiador Projeto
            $row['id_projeto'] = $projeto->id;
            $row['id_financiador'] = $financiador->id;
            $saved = $this->fillAndSave($financiador_projeto,$row,$row_index);

            if($saved and !$financiador_projeto->wasRecentlyCreated){
                $this->log_info($row_index, "u", "Financiador Projeto: " . $financiador_projeto->id);
                $this->incUpdateRecordCount();
            }


        } catch (Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }
}
