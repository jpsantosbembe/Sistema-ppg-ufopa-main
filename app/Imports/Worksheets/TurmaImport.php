<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\NivelCurso;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\ProgPosGrad;
use App\Models\ResponsavelTurma;
use App\Models\Turma;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use Mockery\Exception;

class TurmaImport extends AbstractImport
{
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
        return 'Turmas';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            $pessoa = Pessoa::where('codigo_pessoa', $row['id_pessoa_do_responsavel'])->first();
            if (!$pessoa) {
                $pessoa = new Pessoa();
                $data = [
                    'codigo_pessoa'=>$row['id_pessoa_do_responsavel'] ,
                    'nome'=>$row['nome_do_responsavel'],
                    'incompleto'=>1,
                ];

                $pessoa->fill($data)->save();

            }

            $disciplina = Disciplina::where('codigo_disciplina', $row['id_da_disciplina'])->first();
            if (!$disciplina){
                $disciplina = new Disciplina();
                $this->incNewRecordCount();
                $this->log_info($row_index, "i", "Projeto: " . $disciplina->nome);

            }

            $turma = Turma::where('codigo_turma', $row['identificador_da_turma'])->first();
            if(!$turma){
                $turma = new Turma();
                $this -> incNewRecordCount();
                $this->log_info($row_index, "i", "Projeto: " . $turma->nome);
            }

            $row['id_disciplina'] = $disciplina->id;
            $saved = $this->fillAndSave($turma, $row, $row_index);

            $responsavel_turma = ResponsavelTurma::where([['id_turma',$turma->id], ['id_pessoa', $pessoa->id]])->first();
            if(!$responsavel_turma){
                $responsavel_turma = new ResponsavelTurma();
                $row['id_turma'] = $turma->id;
                $row['id_pessoa'] = $pessoa->id;
                $this->fillAndSave($responsavel_turma, $row, $row_index);
            }

            if ($saved and !$turma->wasRecentlyCreated) {
                $this->log_info($row_index, "u", "Projeto: " . $turma->nome);
                $this->incUpdateRecordCount();
            }

        }catch (\Throwable $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e->getMessage());
        }
    }
}

