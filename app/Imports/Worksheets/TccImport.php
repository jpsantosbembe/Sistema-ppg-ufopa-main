<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\AreaDeConcentracao;
use App\Models\LinhaDePesquisa;
use App\Models\Pessoa;
use App\Models\ProgPosGrad;
use App\Models\Projeto;
use App\Models\Tcc;
use App\Models\TipoTcc;
use App\Models\Upload;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class TccImport extends AbstractImport
{
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
        return 'TCC';
    }


    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();
        try {
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (!$ppg) {
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }
            $row['codigo_do_ppg'] = $ppg->id;
            $area_concentracao = null;
            $projeto = null;
            $linha_pesquisa = null;



            $autor = Pessoa::where(['codigo_pessoa' => $row['identificador_da_pessoa_do_autor']])->first();
            $orientador = Pessoa::where(['codigo_pessoa' => $row['identificador_da_pessoa_do_orientador']])->first();
            if (!$autor) {
                $this->log_error($row_index, "Pessoa '{$row['identificador_da_pessoa_do_autor']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Pessoa '{$row['nome_do_autor']}' não cadastrado");
            }
            if (!$orientador) {
                $this->log_error($row_index, "Orientador com codigo_pessoa '{$row['identificador_da_pessoa_do_orientador']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Orientador '{$row['nome_do_orientador']}' não cadastrado");
            }
            if ($row['area_de_concentracao'] != 'Não informada') {
                $area_concentracao = AreaDeConcentracao::firstOrCreate(['nome' => $row['area_de_concentracao']])->id;
            }
            if ($row['nome_do_projeto'] != 'Não informado') {
               // $projeto = Projeto::where(['nome' => $row['nome_do_projeto']])->firstOrFail()->id;
               $projeto = Projeto::firstOrCreate([ 'nome' =>  $row['nome_do_projeto']],
                   [
                       'id_ppg' => $ppg->id,
                       'nome' => $row['nome_do_projeto']
                   ])->id;

            }
            if ($row['linha_de_pesquisa'] != 'Não informada') {
                $linha_pesquisa = LinhaDePesquisa::where(['nome' => $row['linha_de_pesquisa']])->firstOrFail()->id;
            }
            $row['id_linha'] = $linha_pesquisa;
            $row['id_projeto'] = $projeto;
            $row['id_ac'] = $area_concentracao;
            $tipo_tcc = TipoTcc::firstOrCreate(['nome' => $row['tipo_de_trabalho_de_conclusao']], ['nome' => $row['tipo_de_trabalho_de_conclusao']]);
            $row['id_tipo'] = $tipo_tcc->id;
            $row['id_orientador'] = $orientador->id;
            $row['id_autor'] = $autor->id;
            $saved = $this->fillAndSave(Tcc::newModelInstance(), $row, $row_index);
            if ($saved) {
                $this->incNewRecordCount();
                $this->log_info($row_index, 'i', 'Tcc '.$row['nome_do_trabalho_de_conclusao']);
            }


        } catch (ModelNotFoundException $e) {
            if ($e->getModel() == AreaDeConcentracao::class) {
                $this->log_error($row_index, "Area concentração '{$row['area_de_concentracao']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Área de concentração '{$row['area_de_concentracao']}' não cadastrado");
            }
            if($e->getModel() == Projeto::class){
                $this->log_error($row_index, "Projeto '{$row['linha_de_pesquisa']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Projeto '{$row['nome_do_projeto']}' não cadastrado");
            }
            if($e->getModel() == LinhaDePesquisa::class){
                $this->log_error($row_index, "Linha de Pesquisa '{$row['linha_de_pesquisa']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Projeto '{$row['nome_do_projeto']}' não cadastrado");
            }
            DB::rollBack();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new ImportException($e);
        }
    }
}
