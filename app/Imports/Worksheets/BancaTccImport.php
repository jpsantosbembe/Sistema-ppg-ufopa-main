<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\BancaTcc;
use App\Models\Pessoa;
use App\Models\Tcc;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class BancaTccImport extends AbstractImport
{
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
        return 'Banca TCC';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();
        try {
            $tcc = Tcc::where('codigo_tcc', '=', $row['identificador_do_trabalho_de_conclusao'])->first();
            $pessoa = Pessoa::where('codigo_pessoa', '=', $row['identificador_da_pessoa_da_banca'])->first();
            $orientador = Pessoa::where('codigo_pessoa', '=', $row['identificador_da_pessoa_do_orientador'])->first();
            if (!$tcc) {
                $this->log_error($row_index, "Tcc com codigo '{$row['identificador_do_trabalho_de_conclusao']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: '{$row['nome_do_trabalho_de_conclusao']}' não cadastrado");
            }
            if (!$pessoa) {
                $pessoa = new Pessoa();
                $data = [
                    'identificador_da_pessoa' => $row['identificador_da_pessoa_da_banca'],
                    'nome_pessoa' => $row['nome_da_pessoa_da_banca'],
                    'tipo_de_documento' => $row['tipo_de_documento_da_pessoa_da_banca'],
                    'numero_do_documento' => $row['numero_do_documento_da_pessoa_da_banca'],
                    'pais' => $row['pais_da_pessoa_da_banca'],
                    'incompleto' => 1,
                ];
                $this->fillAndSave($pessoa, $data, $row_index);
                $this->log_pessoa($row_index, 'i', 'pessoa: ', $pessoa);
            }

            if(!$orientador){
                $this->log_error($row_index, "Pessoa com codigo '{$row['identificador_da_pessoa_do_orientador']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: '{$row['nome_do_orientador']}' não cadastrado");
            }
            $row['id_tcc'] = $tcc->id;
            $row['id_pessoa_banca'] = $pessoa->id;
            $row['id_orientador'] = $orientador->id;

            $saved = $this->fillAndSave(BancaTcc::newModelInstance(), $row, $row_index);
            if ($saved) $this->incNewRecordCount();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }
}
