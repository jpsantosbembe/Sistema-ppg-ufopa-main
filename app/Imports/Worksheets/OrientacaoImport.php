<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Imports\Concerns\DateFormatChanger;
use App\Imports\util\ModelSaveException;
use App\Models\Orientacao;
use App\Models\Pessoa;
use App\Models\ProgPosGrad;
use App\Models\Upload;
use App\Models\VinculoDiscente;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;


class OrientacaoImport extends AbstractImport
{
    use DateFormatChanger;

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    /**
     * @throws ImportException
     * @throws ModelSaveException
     */
    public function onRow(Row $row): void
    {

        $row_index = $row->getRowIndex();
        $row = $row->toArray();


        try {
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (! $ppg) {
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            // Busca vínculo do discente
            $vinculo_discente = VinculoDiscente::where('codigo_vinculavel', $row["identificador_do_discente"])->first();
            if ($vinculo_discente) {
                // Evita celulas vazias (Discentes sem orientador)
                if (! empty($row['identificador_do_orientador'])) {
                    // busca vínculo do orientador
                    $orientador = Pessoa::where('codigo_pessoa', $row['identificador_do_orientador'])->first();

                    // Cria uma nova Pessoa para o Orientador somente com código e nome
                    if (! $orientador) {
                        $orientador = new Pessoa();
                        $data = [
                            'identificador_da_pessoa' => $row['identificador_do_orientador'],
                            'nome_pessoa' => $row['nome_do_orientador'],
                            'incompleto' => 1,
                        ];
                        $this->fillAndSave($orientador, $data, $row_index);
                        $this->log_pessoa($row_index, 'i', 'pessoa: ', $orientador);
                    }

                    $orientacao = Orientacao::where([
                        'id_vinculo_discente' => $vinculo_discente->id,
                        'id_orientador' => $orientador->id,
                        'data_inicio' => $this->changeDateFormat($row['inicio_da_orientacao']),
                    ])->first();
                    if (!$orientacao) {
                        // Cria uma nova orientação
                        $orientacao = new Orientacao();
                        $this->incNewRecordCount();
                        $this->log_pessoa($row_index, "i", "orientacao", $orientador);
                    }
                    $row['id_vinculo_discente'] = $vinculo_discente->id;
                    $row['id_orientador'] = $orientador->id;
                    $is_saved = $this->fillAndSave($orientacao, $row, $row_index);

                    // previne contabilizar inclusão como alteração
                    if (! $orientacao->wasRecentlyCreated) {
                        if ($is_saved) $this->log_pessoa($row_index, "u", "orientacao", $orientador);
                    }
                }
            } else {
                $this->log_error($row_index, "Não encontrado Vínculo Discente com o identificador #{$row['identificador_do_discente']}");
                throw new ImportException("ERRO [Linha: $row_index]: " . "Não encontrado Vínculo Discente com o identificador #{$row['identificador_do_discente']}");
            }


        } catch (Exception $e) {
            DB::rollBack();
            throw new ImportException($e);
        }
    }

    function getLabelToLog(): string
    {
        return 'Orientacao';
    }
}
