<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Imports\Concerns\DateFormatChanger;
use App\Models\Categoria;
use App\Models\CategoriaDocente;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\ProgPosGrad;
use App\Models\Upload;
use App\Models\Vinculo;
use App\Models\VinculoDocente;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Row;


class DocenteImport extends AbstractImport
{
    use DateFormatChanger;

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }



    public function onRow(Row $row): void
    {


        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            // Busca ou cria um novo Programa de Pós-graduação
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (! $ppg) {
//                $ppg = new ProgPosGrad();
//                $this->fillAndSave($ppg,$row,$row_index);
//                $this->log_info($row_index, 'I',"Programa de Pós-Graduação '{$row['nome_do_ppg']}' cadastrado");
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            if (!Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa'])->exists()) {

                // Insere nova Pessoa ligada ao VinculoDocente
                $pessoa = new Pessoa();
                $row['nome_pessoa'] = $row['nome_docente'];
                $row['incompleto'] = 0;
                $this->fillAndSave($pessoa, $row, $row_index);


                // Inseriu um novo Programa de Pós-Graduação
                if ($ppg->wasRecentlyCreated) {
                    Log::channel('import')->info("Docente |i| [upload #{$this->getUpload()->id}] (linha: $row_index) ProgPosGrad: " . $ppg->nome);
                }

                // Insere novo VinculoDocente
                $vinculo_docente = new VinculoDocente();

                $this->fillAndSave($vinculo_docente, $row, $row_index);

                // Insere novo Vinculo
                $vinculo = new Vinculo();
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                if ($vinculo_docente->data_desligamento != null) {
                    $vinculo->ativo = 0;
                }
                $vinculo->vinculavel()->associate($vinculo_docente);
                $this->fillAndSave($vinculo, $row, $row_index);

                // Insere Categoria
                $categoria = Categoria::where('nome',$row['categoria'])->first();
                if ($categoria) {
                    $categoria_docente = new CategoriaDocente();
                    $row['id_vinculo_docente'] = $vinculo_docente->id;
                    $row['id_categoria'] = $categoria->id;
                    $this->fillAndSave($categoria_docente, $row, $row_index);
                } else {
                    $this->log_error($row_index, "Categoria não cadastrada");
                    throw new ImportException("ERRO [Linha: $row_index]: Categoria não cadastrada");
                }

                // Incrementa total de registros novos
                $this->incNewRecordCount();
                $this->log_pessoa($row_index, "i", "pessoa", $pessoa);
            } else {
                // Atualiza Pessoa de necessário
                $pessoa = Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa'])->first();
                $row['nome_pessoa'] = $row['nome_docente'];
                $row['incompleto'] = 0;
                $saved = $this->fillAndSave($pessoa, $row, $row_index);

                if ($saved) {
                    $this->log_pessoa($row_index, "u", "pessoa", $pessoa);
                }

                // Atualiza ou cria novo VinculoDocente
                $vinculo_docente = VinculoDocente::where('codigo_vinculavel', $row["identificador_do_docente"])->first();
                if (! $vinculo_docente) {
                    // Cria um novo vínculo para o docente
                    $vinculo_docente = new VinculoDocente();
                    $this->incNewRecordCount();
                    $this->log_pessoa($row_index, "i", "vinculo_docente", $pessoa);
                }
                $is_saved = $this->fillAndSave($vinculo_docente, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo_docente->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo_docente", $pessoa);
                }

                // Atualiza ou cria novo Vinculo se necessário
                if ($vinculo_docente->wasRecentlyCreated) {
                    $vinculo = new Vinculo();
                    $vinculo->vinculavel()->associate($vinculo_docente);
                } else {
                    $vinculo = $vinculo_docente->vinculo;
                }
                $row['id_pessoa'] = $pessoa->id;
                $row['id_ppg'] = $ppg->id;
                if ($vinculo_docente->data_desligamento != null) {
                    $vinculo->ativo = 0; // Previne contabilizar alteração
                }
                $is_saved = $this->fillAndSave($vinculo, $row, $row_index);

                // previne contabilizar inclusão como alteração
                if (! $vinculo->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "vinculo", $pessoa);
                }

                // Atualiza ou cria nova Categoria se necessário
                $categoria = Categoria::where('nome',$row['categoria'])->first();
                $categoria_docente = CategoriaDocente::where([
                    'id_vinculo_docente'=>$vinculo_docente->id,
                    'id_categoria'=>$categoria->id,
                    'data_inicio' => $this->changeDateFormat($row['inicio_da_categoria']),
                ])->first();
                if (! $categoria_docente) {
                    // Cria nova categoria docente
                    $categoria_docente = new CategoriaDocente();
                    //$this->log_info($row_index, "u", "docente->i:categoria", $pessoa);
                }
                $row['id_vinculo_docente'] = $vinculo_docente->id;
                $row['id_categoria'] = $categoria->id;
                $is_saved = $this->fillAndSave($categoria_docente, $row, $row_index);

                // Somente contabilizar alteração se não for em um novo vínculo docente, porque o
                // vínculo já foi contabilizado como inclusão.
                if (! $vinculo_docente->wasRecentlyCreated and ! $categoria_docente->wasRecentlyCreated) {
                    $saved = $saved || $is_saved;
                    if ($is_saved) $this->log_pessoa($row_index, "u", "categoria", $pessoa);
                }

                // Incrementa total de registros alterados
                if ($saved) {
                    $this->incUpdateRecordCount();
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }

    function getLabelToLog(): string
    {
        return 'Docente';
    }
}
