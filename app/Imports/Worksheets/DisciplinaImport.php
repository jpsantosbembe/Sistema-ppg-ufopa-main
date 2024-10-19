<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\AreaDeConcentracao;
use App\Models\Curso;
use App\Models\DisciplinaAc;
use App\Models\Disciplina;
use App\Models\NivelCurso;
use App\Models\ProgPosGrad;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use function PHPUnit\Framework\isEmpty;

class DisciplinaImport extends AbstractImport
{
    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    function getLabelToLog(): string
    {
        return 'Disciplinas';
    }

    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();

        try {
            $ppg = ProgPosGrad::where('codigo_ppg', $row['codigo_do_ppg'])->first();
            if (!$ppg){
                $this->log_error($row_index, "Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Programa de Pós-Graduação '{$row['nome_do_ppg']}' não cadastrado");
            }

            $nivel_curso = NivelCurso::where('tipo', $row['nivel_do_curso'])->first();
            if(!$nivel_curso){
                $nivel_curso = new NivelCurso();
                $this->fillAndSave($nivel_curso, $row, $row_index);
            }

            $area_de_concentracao = AreaDeConcentracao::where('nome', $row['area_de_concentracao'])->first();
            if (!$area_de_concentracao ){
                $area_de_concentracao = new AreaDeConcentracao();
            }
            if(!isEmpty($row['area_de_concentracao'])){
                $this->fillAndSave($area_de_concentracao, $row, $row_index);
            }

            $curso = Curso::where('codigo_curso', $row['codigo_do_curso'])->first();
            if (!$curso){
                $curso = new Curso();
            }
            $row['id_ppg'] = $ppg->id;
            $row['id_nivel'] = $nivel_curso->id;
            $this->fillAndSave($curso, $row, $row_index);

            $disciplina = Disciplina::where('codigo_disciplina', $row['id_da_disciplina'])->first();
            if (!$disciplina){
                $disciplina = new Disciplina();
                $this->incNewRecordCount();
                $this->log_info($row_index, "i", "Projeto: " . $disciplina->nome);

            }

            $row['id_curso'] = $curso->id;
            $saved = $this->fillAndSave($disciplina, $row, $row_index);

            if ($saved and !$disciplina->wasRecentlyCreated) {
                $this->log_info($row_index, "u", "Projeto: " . $disciplina->nome);
                $this->incUpdateRecordCount();
            }

            $disciplina_ac = DisciplinaAc::where([['id_disciplina',$disciplina->id], ['id_ac', $area_de_concentracao->id]])->first();
            if(!$disciplina_ac){
                $disciplina_ac = new DisciplinaAc();
                $row['id_disciplina'] = $disciplina->id;
                $row['id_ac'] = $area_de_concentracao?->id;
                $this->fillAndSave($disciplina_ac, $row, $row_index);
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }
}
