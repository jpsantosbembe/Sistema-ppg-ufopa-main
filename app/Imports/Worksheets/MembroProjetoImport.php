<?php

namespace App\Imports\Worksheets;

use App\Exceptions\ImportException;
use App\Models\MembroProjeto;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\Projeto;
use App\Models\Upload;
use App\Models\VinculoDiscente;
use App\Models\VinculoDocente;
use App\Models\VinculoExterno;
use App\Models\VinculoPosDoc;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;

class MembroProjetoImport extends AbstractImport
{

    public function __construct(Upload $upload, string $sheet_name)
    {
        parent::__construct($upload, $sheet_name);
    }

    /**
     * @throws ImportException
     */
    public function onRow(Row $row)
    {
        $row_index = $row->getRowIndex();
        $row = $row->toArray();
        DB::beginTransaction();
        try {
            $projeto = Projeto::where('codigo_projeto',$row['identificador_do_projeto_de_pesquisa'])->first();
            if(!$projeto){
                $this->log_error($row_index, "Projeto '{$row['nome_do_projeto_de_pesquisa']}' não cadastrado");
                throw new ImportException("ERRO [Linha: $row_index]: Projeto '{$row['nome_do_projeto_de_pesquisa']}' não cadastrado");
            }
            $pessoa = Pessoa::where('codigo_pessoa', $row['identificador_da_pessoa_do_membro'])->first();

            if(!$pessoa){
                $pessoa = new Pessoa();
                $data = [
                    'identificador_da_pessoa' => $row['identificador_da_pessoa_do_membro'],
                    'nome_pessoa' => $row['nome_do_membro_do_projeto'],
                    'incompleto' => true,
                ];
                $this->fillAndSave($pessoa, $data, $row_index);
                $this->log_pessoa($row_index, 'i', 'pessoa: ', $pessoa);
            } else {
                // Marca o projeto com membro no cadastro
                if (! ($pessoa->incompleto or $projeto->tem_membro_cad) ) {
                    $this->fillAndSave($projeto, ['tem_membro_cad' => 1], $row_index);
                    $this->log_info($row_index, 'u', 'projeto: ' . $projeto->nome);
                }
            }

            $pessoa->load([
                'vinculos'=>function ($query) use($row,$projeto) {
                    $query->where([
                        'vinculavel_type'=>$this->getVinculoName($row['categoria_do_membro_do_projeto']),
                        'id_ppg'=>$projeto->ppg->id
                    ]);
                }
            ]);


            $membro_projeto = MembroProjeto::where([
                ['id_pessoa','=',$pessoa->id],
                ['id_projeto','=',$projeto->id],
            ])->first();


            if(!$membro_projeto){
                $membro_projeto =  new MembroProjeto();
                $this->log_info($row_index, "i", "projeto: " . $projeto->nome);
                $this->incNewRecordCount();
            }

            $row['id_pessoa'] = $pessoa->id;
            $row['id_projeto'] = $projeto->id;
            $row['vinculo_id'] = $pessoa->vinculos->first()?->id;
            $row['membro_responsavel'] = strtoupper($row['membro_responsavel']) == 'SIM';

            $saved = $this->fillAndSave($membro_projeto, $row, $row_index);

            if ($saved and ! $membro_projeto->wasRecentlyCreated) {
                $this->log_info($row_index, "u", "projeto: " . $projeto->nome);
                $this->incUpdateRecordCount();
            }

            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            $this->log_error($row_index, $e->getMessage());
            throw new ImportException($e);
        }
    }

    function getVinculoName($categoria): string
    {
        return match ($categoria) {
            'Docente' => VinculoDocente::class,
            'Discente' => VinculoDiscente::class,
            'Participante Externo' => VinculoExterno::class,
            'Pós-Doc' => VinculoPosDoc::class,
            default => '',
        };

    }

    function getLabelToLog(): string
    {
        return 'Membros de Projetos';
    }
}
