<?php

namespace App\Service;

use App\Models\Orientacao;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Reports
{
    function qualis(): Collection
    {
        $subQuery = DB::table('producoes as p')
            ->select('p.issn', 'p.ano_publicacao', 'p.nome', 'ap.id_pessoa')
            ->distinct()
            ->join('autores_producoes as ap', 'p.id', '=', 'ap.id_producao')
            ->where('p.issn', '!=', '');

        if (request('program_id')) {
            $subQuery->addSelect('ppgs.nome as programa_name')
                ->join('ppgs', 'ppgs.id', '=', 'p.id_ppg')
                ->where('ppgs.id', '=', request('program_id'));
        }

        $subQuerySql = DB::raw("({$subQuery->toSql()}) as pd");

        $query = DB::table('pessoas as ps')
            ->join($subQuerySql, 'pd.id_pessoa', '=', 'ps.id')
            ->mergeBindings($subQuery)
            ->join('qualis as q', 'q.issn', '=', 'pd.issn')
            ->where('ps.id', '!=', 0)
            ->whereBetween('pd.ano_publicacao', [request('init_year'), request('end_year')])
            ->whereExists(function($query) {
                $query->select(DB::raw(1))
                    ->from('vinculos as v')
                    ->join('vinculos_docentes as vd', 'vd.id', '=', 'v.vinculavel_id')
                    ->join('categorias_docentes as cd', 'cd.id_vinculo_docente', '=', 'vd.id')
                    ->whereColumn('v.id_pessoa', 'ps.id')
                    ->where('v.vinculavel_type', '=', 'App\\Models\\VinculoDocente')
                    ->where('cd.id_categoria', '=', 1)
                    ->whereRaw('(YEAR(cd.data_inicio) <= ?) AND (YEAR(cd.data_fim) >= ? OR cd.data_fim IS NULL)', [ request('init_year'),request('end_year')]);
            });

        $query->select(
            'ps.id',
            'ps.nome',
            DB::raw("SUM(CASE WHEN q.estratos = 'A1' THEN 1 ELSE 0 END) AS A1"),
            DB::raw("SUM(CASE WHEN q.estratos = 'A2' THEN 1 ELSE 0 END) AS A2"),
            DB::raw("SUM(CASE WHEN q.estratos = 'A3' THEN 1 ELSE 0 END) AS A3"),
            DB::raw("SUM(CASE WHEN q.estratos = 'A4' THEN 1 ELSE 0 END) AS A4"),
            DB::raw("SUM(CASE WHEN q.estratos = 'B1' THEN 1 ELSE 0 END) AS B1"),
            DB::raw("SUM(CASE WHEN q.estratos = 'B2' THEN 1 ELSE 0 END) AS B2"),
            DB::raw("SUM(CASE WHEN q.estratos = 'B3' THEN 1 ELSE 0 END) AS B3"),
            DB::raw("SUM(CASE WHEN q.estratos = 'B4' THEN 1 ELSE 0 END) AS B4"),
            DB::raw("SUM(CASE WHEN q.estratos = 'C' THEN 1 ELSE 0 END) AS C")
        )->groupBy('ps.id');

        if (request('program_id')) {
            $query->addSelect('pd.programa_name')->groupBy('pd.programa_name');
        }

        return $query->orderBy('ps.id')->get();
    }
    function orientations(): Collection|array
    {
        $date = request('year');
        $programId = request('program_id');
        $orientadorId = request('orientador_id');

        return DB::table('orientacoes as ori')
            ->select('op.nome as orientador_nome', 'dp.nome as discente_nome', 'ppgs.nome as programa_nome', 'ori.data_inicio', 'ori.data_fim', 'ori.ativo')
            ->join('pessoas as op', 'op.id', '=', 'ori.id_orientador')
            ->join('vinculos as v', function($join) {
                $join->on('v.vinculavel_id', '=', 'ori.id_vinculo_discente')
                    ->where('v.vinculavel_type', '=', 'App\\Models\\VinculoDiscente');
            })
            ->join('pessoas as dp', 'dp.id', '=', 'v.id_pessoa')
            ->join('ppgs', 'ppgs.id', '=', 'v.id_ppg')
            ->when($date, function ($query) use ($date) {
                $query->whereRaw('? between YEAR(ori.data_inicio) and YEAR(ori.data_fim)', [$date]);
            })
            ->when($orientadorId, function ($query) use ($orientadorId) {
                $query->where('op.id', $orientadorId);
            })
            ->when($programId, function ($query) use ($programId) {
                $query->where('ppgs.id', $programId);
            })
            ->orderBy('op.nome')
            ->get();


    }
}
