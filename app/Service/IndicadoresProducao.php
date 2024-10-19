<?php

namespace App\Service;

use App\Models\Pessoa;
use App\Models\Producao;
use App\Models\TipoProducao;

use App\Service\interfaces\IndicadoresProducaoInterface;

class IndicadoresProducao implements IndicadoresProducaoInterface
{
    private readonly string $table_name;

    public function __construct()
    {
        $this->table_name = Producao::newModelInstance()->getTable();

    }

    public function qtde_producoes_tecnicas(mixed $id_pessoa, mixed $id_ppg = null)
    {
        $id_tecnica = TipoProducao::where('nome', 'TÉCNICA')->first(['id'])->id;
        return Pessoa::where('id', '=', $id_pessoa)->first()->producoes()
            ->where('id_tipo', '=', $id_tecnica)
            ->when($id_ppg, fn($query) => $query->where('id_ppg', '=', $id_ppg))
            ->count();
    }

    public function qtde_producoes_bibliograficas(mixed $id_pessoa, mixed $id_ppg = null)
    {
        $id_tecnica = TipoProducao::where('nome', 'BIBLIOGRÁFICA')->first(['id'])->id;
        return Pessoa::where('id', '=', $id_pessoa)->first()->producoes()
            ->where('id_tipo', '=', $id_tecnica)
            ->when($id_ppg, fn($query) => $query->where('id_ppg', '=', $id_ppg))
            ->count();
    }

    public function qtde_producoes_com_qualis(mixed $id_pessoa = null, mixed $id_ppg = null)
    {
        return Producao::query()
            ->where('id_ppg', '=', $id_ppg)
            ->WhereHas('qualis');

    }

    public function qtde_producoes_por_qualis(mixed $id_pessoa = null, mixed $id_ppg = null, string $year=null)
    {
        $query =  Producao::where(function ($query) use ($id_ppg,$year) {
            $query->where('id_ppg', '=', $id_ppg);
            if($year){
                $query->where('ano_publicacao', '=', $year);
            }
        })->join('qualis', 'producoes.issn', '=', 'qualis.issn')
            ->selectRaw('qualis.estratos, COUNT(*) as qtde');

        if($year){
            $query = $query->groupBy('producoes.ano_publicacao', 'qualis.estratos');
        }else{
            $query = $query->groupBy( 'qualis.estratos');
        }

        return $query->orderBy('qualis.estratos')->get();

    }
}
