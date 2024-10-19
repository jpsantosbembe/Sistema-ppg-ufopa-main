<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\AreaDeConcentracao;
use App\Models\ProgPosGrad;
use App\Models\Projeto;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use Mockery\Exception;

class ProjetoImport extends AbstractImport
{

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    /**
     * @throws ImportException
     */
    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            // Verifica se existe o Programa de Pós-graduação
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (!$ppg) {
//                $ppg = new ProgPosGrad();
//                $this->fillAndSave($ppg,$row,$row_index);
//                $this->log_info($row_index, 'I',"Programa de Pós-Graduação '{$row['nome_do_ppg']}' cadastrado");
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            // Verifica se existe o projeto
            $projeto = Projeto::where('codigo_projeto',$row['identificador_do_projeto_de_pesquisa'])
                ->orWhere(function ($query) {
                    $query->where('nome', 'nome_do_projeto_de_pesquisa')
                        ->whereNull('codigo_projeto');
                })
                ->first();
            if(!$projeto){
                $projeto = new Projeto();
                $this->log_info($row_index, "i", "Projeto: " . $projeto->nome);
                $this->incNewRecordCount();
            }

            // Cria area de concentração apenas para projetos sem linha de pesquisa
            $area_concentracao = null;
            if ( ! empty($row['area_de_concentracao']) ) {
                $area_concentracao = AreaDeConcentracao::where('nome', $row['area_de_concentracao'])->first();
                if (!$area_concentracao) {
                    $area_concentracao = new AreaDeConcentracao();
                    $this->fillAndSave($area_concentracao, $row, $row_index);
                }
            }

            $row['id_ppg'] = $ppg->id;
            $row['id_ac'] = $area_concentracao?->id;
            $saved = $this->fillAndSave($projeto, $row, $row_index);

            // Contagem de alteração
            if ($saved and ! $projeto->wasRecentlyCreated) {
                $this->log_info($row_index, "u", "Projeto: " . $projeto->nome);
                $this->incUpdateRecordCount();
            }

        }catch (Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e->getMessage());
        }
    }
    function getLabelToLog(): string
    {
        return 'Projetos';
    }
}
