<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\Financiador;
use App\Models\FinanciadoresTcc;
use App\Models\Tcc;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class FinanciadoresTccImport extends AbstractImport

{
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
        return 'Financiadores TCC';
    }

    /**
     * @param Row $row
     * @return void
     * @throws ImportException
     */
    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();
        if (empty($row['numero_do_documento_do_financiador'])) {
            return;
        }

        try {
            $financiador = Financiador::firstOrCreate([
                'doc' => $row['numero_do_documento_do_financiador']
            ], [
                'tipo_doc' => $row['tipo_de_documento_do_financiador'],
                'doc' => $row['numero_do_documento_do_financiador'],
                'nome' => $row['nome_do_financiador']
            ]);
            $tcc = Tcc::where('codigo_tcc', '=', $row['identificador_do_trabalho_de_conclusao'])->first();
            if (!$tcc) {
                $this->log_error($row_index, "Tcc com codigo '{$row['identificador_do_trabalho_de_conclusao']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: '{$row['nome_do_trabalho_de_conclusao']}' não cadastrado");
            }
            $row['id_tcc'] = $tcc->id;
            $row['id_financiador'] = $financiador->id;
            $financiador_tcc = FinanciadoresTcc::where([
                'id_tcc' => $tcc->id,
                'id_financiador' => $financiador->id
            ])->first();
            if (!$financiador_tcc) {
                $saved = $this->fillAndSave(FinanciadoresTcc::newModelInstance(), $row, $row_index);
                if ($saved) {
                    $this->incNewRecordCount();
                    $this->log_info($row_index, 'c', 'financiador ' . $financiador->nome . ' cadastrado para o tcc: "' . $tcc->nome . '"');
                }
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e->getMessage());
        }
    }
}
