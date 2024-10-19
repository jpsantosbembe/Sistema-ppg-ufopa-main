<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\DetalheProducao;
use App\Models\Producao;
use App\Models\Qualis;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class DetalheProducaoImport  extends AbstractImport
{

    function getLabelToLog(): string
    {
        return 'Detalhes produção';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            if(!empty($row['valor_do_item_de_detalhamento'])){
                $producao = Producao::where('codigo_producao',$row['id_da_producao'])->first();
                if(!$producao){
                    $this->log_error($row_index, "Produção '{$row['id_da_producao']}' não cadastrado");
                    throw new ImportException("ERRO [Linha: $row_index]: Produção '{$row['id_da_producao']}' não cadastrado");
                }

                $detalhe_producao = DetalheProducao::where([
                    ['id_producao', $producao->id],
                    ['item', $row['item_de_detalhamento']]
                ])->first();
                if(!$detalhe_producao){
                    $detalhe_producao = new DetalheProducao();
                    $this->log_info($row_index, "i", "Autor Producao: " . $producao->nome.' - '.$detalhe_producao->item.':'.$detalhe_producao->valor_item);
                    $this->incNewRecordCount();
                }

                $row['id_producao'] = $producao->id;
                $saved = $this->fillAndSave($detalhe_producao, $row,$row_index);


                if ($saved and !$detalhe_producao->wasRecentlyCreated) {
                    $this->log_info($row_index, "u", "Autor Producao: " . $producao->nome.' - '.$detalhe_producao->item.':'.$detalhe_producao->valor_item);
                    $this->incUpdateRecordCount();
                }
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }
}
