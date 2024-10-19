<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Imports\util\ModelSaver;
use App\Models\AutorProducao;
use App\Models\Pessoa;
use App\Models\Producao;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class AutorProducaoImport extends AbstractImport
{

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
        return 'Autores Produções';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();
        try {
            $producao = Producao::where('codigo_producao',$row['id_da_producao'])->first();
            if(!$producao){
                $this->log_error($row_index, "Produção '{$row['id_da_producao']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Produção '{$row['id_da_producao']}' não cadastrado");
            }

            $pessoa = Pessoa::where('codigo_pessoa',$row['id_pessoa_do_autor'])->first();
            if(!$pessoa){
                $pessoa = new Pessoa();
                $data = [
                    'identificador_da_pessoa' => $row['id_pessoa_do_autor'],
                    'nome_pessoa' => $row['nome_do_autor'],
                    'incompleto' => 1,
                ];
                $this->fillAndSave($pessoa, $data, $row_index);
                $this->log_pessoa($row_index, 'i', 'pessoa: ', $pessoa);
            }

            // Necessário para espelhar o banco do MEC
            if ($pessoa->id == 0) {
                $row['nome_autor'] = $row['nome_do_autor'];
            } else {
                $row['nome_autor'] = null;
            }

            $autor_producao = AutorProducao::where([
                ['id_pessoa',$pessoa->id],
                ['id_producao',$producao->id],
                ['nome_autor', $row['nome_autor']],
            ])->first();
            if(!$autor_producao){
                $autor_producao = new AutorProducao();
                $this->log_info($row_index, "i", "Autor Producao: " . $producao->nome.' - '.$pessoa->nome);
                $this->incNewRecordCount();
            }

            $row['id_pessoa'] = $pessoa->id;
            $row['id_producao'] = $producao->id;
            $saved = $this->fillAndSave($autor_producao, $row,$row_index);

            if ($saved and !$autor_producao->wasRecentlyCreated) {
                $this->log_info($row_index, "u", "Autor Producao: " . $producao->nome.' - '.$pessoa->nome);
                $this->incUpdateRecordCount();
            }


        } catch (\Throwable $e) {

            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }
}
