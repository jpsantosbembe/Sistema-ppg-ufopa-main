<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\AreaDeConcentracao;
use App\Models\LinhaDePesquisa;
use App\Models\LinhaProjeto;
use App\Models\ProgPosGrad;
use App\Models\Projeto;
use App\Models\Upload;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class LinhaDePesquisaImport extends AbstractImport
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
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            // Atualiza ou cria area de concentração
            $area_concentracao = null;
            if (! empty($row['area_de_concentracao'])) {
                $area_concentracao = AreaDeConcentracao::where('nome', $row['area_de_concentracao'])->first();
                if (! $area_concentracao) {
                    $area_concentracao = new AreaDeConcentracao();
                }
                $area_concentracao->codigo_ac = $row['identificador_da_area_de_concentracao'];
                $this->fillAndSave($area_concentracao, $row, $row_index);
            }

            // Verifica se a linha já existe
            $linha = LinhaDePesquisa::where('codigo_lp', $row['identificador_da_linha_de_pesquisa'])->first();
            if(!$linha){
                $linha = new LinhaDePesquisa();
            }

            // Cria a linha
            $row['id_ppg'] = $ppg->id;
            $row['id_ac'] = $area_concentracao?->id;
            $saved = $this->fillAndSave($linha, $row, $row_index);

            // Verificar se existe o Projeto
            $projeto = Projeto::where('codigo_projeto',$row['identificador_do_projeto'])->first();
            if(!$projeto){
                $this->log_error($row_index, "Projeto '{$row['nome_do_projeto_de_pesquisa']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Projeto '{$row['nome_do_projeto_de_pesquisa']}' não cadastrado");
            }else{
                $linha_projeto = new LinhaProjeto();
                $row['id_projeto'] = $projeto->id;
                $row['id_lp'] = $linha->id;
                $this->fillAndSave($linha_projeto, $row, $row_index);
            }

            if ($saved) {
                if($linha->wasRecentlyCreated){
                    $this->log_info($row_index, "i", "linha_de_pesquisa: " . $linha->nome);
                    $this->incNewRecordCount();
                }else{
                    $this->log_info($row_index, "u", "linha_de_pesquisa: " . $linha->nome);
                    $this->incUpdateRecordCount();
                }
            }


        }catch (Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }


    }

    function getLabelToLog(): string
    {
        return 'Linha de pesquisa';
    }
}
