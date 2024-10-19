<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\ProgPosGrad;
use App\Models\Upload;
use App\Models\Vinculo;
use App\Models\VinculoDiscente;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;


class DiscenteImport extends AbstractImport
{

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    public function onRow(Row $row): void
    {

        $row_index = $row->getRowIndex();
        $row = $row->toArray();


        try {
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (! $ppg) {
                $ppg = new ProgPosGrad();
//                $this->fillAndSave($ppg,$row,$row_index);
//                $this->log_info($row_index, 'I',"Programa de Pós-Graduação '{$row['nome_do_ppg']}' cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            if (!Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa'])->exists()) {
                // Insere nova Pessoa ligada ao VinculoDocente
                $pessoa = new Pessoa();
                $row['nome_pessoa'] = $row['nome_discente'];
                $row['incompleto'] = 0;
                $this->fillAndSave($pessoa, $row, $row_index);

                // Insere novo VinculoDiscente
                $vinculo_discente = new VinculoDiscente();
                $this->fillAndSave($vinculo_discente, $row, $row_index);

                // Insere novo Vinculo

                $vinculo = new Vinculo();
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                if ($vinculo_discente->situacao != 'MATRICULADO') {
                    $vinculo->ativo = 0;
                }


                $vinculo->vinculavel()->associate($vinculo_discente);
                $this->fillAndSave($vinculo, $row, $row_index);

                // Incrementa total de registros novos
                $this->incNewRecordCount();
                $this->log_pessoa($row_index, "i", "pessoa", $pessoa);
            } else {
                // Atualiza Pessoa de necessário
                $pessoa = Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa'])->first();
                $row['nome_pessoa'] = $row['nome_discente'];
                $row['incompleto'] = 0;
                $saved = $this->fillAndSave($pessoa, $row, $row_index);

                if ($saved) {
                    $this->log_pessoa($row_index, "u", "pessoa", $pessoa);
                }

                // Atualiza ou cria novo VinculoDiscente
                $vinculo_discente = VinculoDiscente::where('codigo_vinculavel', $row["identificador_do_discente"])->first();
                if (! $vinculo_discente) {
                    // Cria um novo vínculo para o discente
                    $vinculo_discente = new VinculoDiscente();
                    $this->incNewRecordCount();
                    $this->log_pessoa($row_index, "i", "vinculo_discente", $pessoa);
                }
                $is_saved = $this->fillAndSave($vinculo_discente, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo_discente->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo_discente", $pessoa);
                }

                // Atualiza ou cria novo Vinculo se necessário
                if ($vinculo_discente->wasRecentlyCreated) {
                    $vinculo = new Vinculo();
                    $vinculo->vinculavel()->associate($vinculo_discente);
                } else {
                    $vinculo = $vinculo_discente->vinculo;
                }
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                if ($vinculo_discente->situacao != 'MATRICULADO') {
                    $vinculo->ativo = 0; // Previne falsa notificação de alteração
                }
                $is_saved = $this->fillAndSave($vinculo, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo", $pessoa);
                }

                // Incrementa total de registros alterados
                if ($saved) $this->incUpdateRecordCount();
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw new ImportException($e);
        }
    }

    function getLabelToLog(): string
    {
        return 'Discente';
    }
}
