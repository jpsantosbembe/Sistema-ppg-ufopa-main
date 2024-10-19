<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\LinhaDePesquisa;
use App\Models\Producao;
use App\Models\ProgPosGrad;
use App\Models\Projeto;
use App\Models\SubTipoProducao;
use App\Models\TipoProducao;
use App\Models\Upload;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use function PHPUnit\Framework\isEmpty;

class ProducaoImport extends AbstractImport
{
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
       return 'produção';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (!$ppg) {
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            $tipo = TipoProducao::where('nome',$row['tipo_de_producao'])->first();
            if(!$tipo){
                $tipo = new TipoProducao();
                $this->fillAndSave($tipo,$row,$row_index);
            }

            $subtipo = SubTipoProducao::where('nome',$row['subtipo_de_producao'])->first();
            if(!$subtipo){
                $subtipo = new SubTipoProducao();
                $this->fillAndSave($subtipo,$row,$row_index);
            }

            $linha = LinhaDePesquisa::where('nome',$row['linha_de_pesquisa'])->first();
            if(!$linha and !isEmpty($row['linha_de_pesquisa'])){
                $this->log_error($row_index, "Linha de Pesquisa '{$row['linha_de_pesquisa']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Linha de Pesquisa '{$row['linha_de_pesquisa']}' não cadastrado");
            }

            $projeto = Projeto::where('nome',$row['projeto'])->first();
            if(!$projeto and !isEmpty($row['projeto'])){
                $this->log_error($row_index, "Projeto '{$row['projeto']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Projeto '{$row['projeto']}' não cadastrado");
            }

            $producao = Producao::where('codigo_producao', $row['id_da_producao'])->first();
            if(!$producao){
                $producao = new Producao();
                $this->log_info($row_index, "i", "projeto: " . $producao->nome);
                $this->incNewRecordCount();
            }

            $row['id_ppg'] = $ppg->id;
            $row['id_tipo'] = $tipo->id;
            $row['id_subtipo'] = $subtipo->id;
            $row['id_lp'] = $linha?->id;
            $row['id_projeto'] = $projeto?->id;

            $saved = $this->fillAndSave($producao,$row, $row_index);

            if ($saved and !$producao->wasRecentlyCreated) {
                $this->log_info($row_index, "u", "projeto: " . $producao->nome);
                $this->incUpdateRecordCount();
            }

        } catch (Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }
}
