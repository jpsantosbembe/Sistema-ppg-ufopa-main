<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\ProgPosGrad;
use App\Models\Upload;
use App\Models\Vinculo;
use App\Models\VinculoExterno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Row;


class ExternoImport extends AbstractImport
{

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    /**
     * @throws ImportException
     */
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

            $pessoa = Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa_do_participante'])->first();
            if (!$pessoa) {
                // Insere nova Pessoa ligada ao VinculoDocente
                $pessoa = new Pessoa();
                $row['identificador_da_pessoa'] = $row['identificador_da_pessoa_do_participante'];
                $row['nome_pessoa'] = $row['nome_do_participante'];
//                $row['incompleto'] = 1;
                $this->fillAndSave($pessoa, $row, $row_index);

                // Inseriu um novo Programa de Pós-Graduação
                if ($ppg->wasRecentlyCreated) {
                    Log::channel('import')->info("ParticipanteExterno |i| [upload #{$this->getUpload()->id}] (linha: $row_index) ProgPosGrad: " . $ppg->nome);
                }

                // Insere novo VinculoExterno
//                $vinculo_externo = VinculoExterno::where('codigo_vinculavel', $row["identificador_do_participante"])->first();
                $vinculo_externo = new VinculoExterno();
//                if (!$vinculo_externo) {
//
//                    // Cria um novo vínculo para o docente
//                    $vinculo_externo = new VinculoExterno();
//                    $this->incNewRecordCount();
//                    $this->log_pessoa($row_index, "i", "vinculo_externo", $pessoa);
//                }
                $this->fillAndSave($vinculo_externo, $row, $row_index);

                // Insere novo Vinculo
                $vinculo = new Vinculo();
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                $vinculo->vinculavel()->associate($vinculo_externo);
                $this->fillAndSave($vinculo, $row, $row_index);

                // Incrementa total de registros novos
                $this->incNewRecordCount();
                $this->log_pessoa($row_index, "i", "pessoa", $pessoa);
            } else {
                // Atualiza Pessoa de necessário
                $row['identificador_da_pessoa'] = $row['identificador_da_pessoa_do_participante'];
                $row['nome_pessoa'] = $row['nome_do_participante'];
                $saved = $this->fillAndSave($pessoa, $row, $row_index);

                if ($saved) {
                    $this->log_pessoa($row_index, "u", "pessoa", $pessoa);
                }

                // Atualiza ou cria novo VinculoExterno
                $vinculo_externo = VinculoExterno::where('codigo_vinculavel', $row["identificador_do_participante"])->first();
                if (!$vinculo_externo) {
                    // Cria um novo vínculo para o docente
                    $vinculo_externo = new VinculoExterno();
                    $this->incNewRecordCount();
                    $this->log_pessoa($row_index, "i", "vinculo_externo", $pessoa);
                }
                $is_saved = $this->fillAndSave($vinculo_externo, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo_externo->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo_externo", $pessoa);
                }

                // Atualiza ou cria novo Vinculo se necessário
                if ($vinculo_externo->wasRecentlyCreated) {
                    $vinculo = new Vinculo();
                    $vinculo->vinculavel()->associate($vinculo_externo);
                } else {
                    $vinculo = $vinculo_externo->vinculo;
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
        return 'ParticipanteExterno';
    }
}
