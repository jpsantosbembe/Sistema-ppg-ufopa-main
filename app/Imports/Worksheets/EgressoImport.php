<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\ProgPosGrad;
use App\Models\Upload;
use App\Models\Vinculo;
use App\Models\VinculoEgresso;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;


class EgressoImport extends AbstractImport
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
            // Busca Programa de Pós-graduação
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (! $ppg) {
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            if (!Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa_do_egresso'])->exists()) {
                // Insere nova Pessoa ligada ao VinculoDocente
                $pessoa = new Pessoa();
                $row['identificador_da_pessoa'] = $row['identificador_da_pessoa_do_egresso'];
                $row['nome_pessoa'] = $row['nome_do_egresso'];
                $row['incompleto'] = 0;
                $this->fillAndSave($pessoa, $row, $row_index);


                // Insere novo VinculoPosDoc
                $vinculo_egresso = new VinculoEgresso();
                $this->fillAndSave($vinculo_egresso, $row, $row_index);

                // Insere novo Vinculo
                $vinculo = new Vinculo();
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                $vinculo->vinculavel()->associate($vinculo_egresso);
                $this->fillAndSave($vinculo, $row, $row_index);

                // Incrementa total de registros novos
                $this->incNewRecordCount();
                $this->log_pessoa($row_index, "i", "pessoa", $pessoa);
            } else {
                // Atualiza Pessoa de necessário
                $pessoa = Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa_do_egresso'])->first();
                $row['identificador_da_pessoa'] = $row['identificador_da_pessoa_do_egresso'];
                $row['nome_pessoa'] = $row['nome_do_egresso'];
                $row['incompleto'] = 0;
                $saved = $this->fillAndSave($pessoa, $row, $row_index);

                if ($saved) {
                    $this->log_pessoa($row_index, "u", "pessoa", $pessoa);
                }

                // Atualiza ou cria novo VinculoPosDoc
                $vinculo_egresso = VinculoEgresso::where('codigo_vinculavel', $row["identificador_do_egresso"])->first();
                if (! $vinculo_egresso) {
                    // Cria um novo vínculo para o docente
                    $vinculo_egresso = new VinculoEgresso();
                    $this->incNewRecordCount();
                    $this->log_pessoa($row_index, "i", "vinculo_egresso", $pessoa);
                }
                $is_saved = $this->fillAndSave($vinculo_egresso, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo_egresso->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo_egresso", $pessoa);
                }

                // Atualiza ou cria novo Vinculo se necessário
                if ($vinculo_egresso->wasRecentlyCreated) {
                    $vinculo = new Vinculo();
                    $vinculo->vinculavel()->associate($vinculo_egresso);
                } else {
                    $vinculo = $vinculo_egresso->vinculo;
                }
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                $is_saved = $this->fillAndSave($vinculo, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo", $pessoa);
                }

                // Incrementa total de registros alterados
                if ($saved) $this->incUpdateRecordCount();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }

    function getLabelToLog(): string
    {
        return 'Egresso';
    }
}
