<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\Coleta;
use App\Models\Item;
use App\Models\ProgPosGrad;
use App\Models\Quesito;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class PropostaImport extends AbstractImport
{
    function getLabelToLog(): string
    {
        return 'Porposta';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try{

            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if(!$ppg){
                throw  new ImportException('PPG '.$row['nome_do_ppg']. ' não cadastrado');
            }
            $coleta = Coleta::firstOrNew([
                'id_ppg' => $ppg->id,
                'ano_calendario' => $row['ano_do_calendario']
            ], [

            ]);
            $row['id_ppg'] = $ppg->id;
            $this->fillAndSave($coleta, $row, $row_index);
            $quesito = Quesito::firstOrNew(
                [ 'id_coleta' => $coleta->id, 'nome' => $row['quesito']  ]
            );
            $row['id_coleta'] = $coleta->id;
            $this->fillAndSave($quesito, $row, $row_index);
            $row['id_quesito'] = $quesito->id;
            $item = Item::newModelInstance();
            $saved = $this->fillAndSave($item, $row, $row_index);
            if($saved) $this->incNewRecordCount();

        }catch (\Throwable $e){
            DB::rollBack();
            throw  $e;
        }
    }
}
