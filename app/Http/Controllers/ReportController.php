<?php

namespace App\Http\Controllers;

use App\Models\Orientacao;
use App\Models\Producao;
use App\Models\ProgPosGrad;
use App\Service\Reports;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function __construct(
        private readonly Reports $reportsService,
    ){}
    function qualis()
    {
        $ppgs = ProgPosGrad::query()->get();
        $years = Producao::query()->select('ano_publicacao')->distinct()->get()->pluck('ano_publicacao')->toArray();
        return Inertia::render('Reports/Qualis',compact('ppgs','years'));
    }

    function orientations()
    {
        $ppgs = ProgPosGrad::query()->get();
        $orientations = Orientacao::query()->with('orientador')->select(DB::raw("id_orientador,YEAR(data_inicio) as start,YEAR(data_fim) as end"))->distinct()->get();
        $people = $orientations->map(fn ($item) => $item->orientador);

        $years = $orientations->flatMap(function($item) {
            return [$item->start, $item->end];
        })->filter()->unique()->sort()->values()->all();
        return Inertia::render('Reports/Orientations',compact('ppgs','people','years'));
    }

    function apiOrientations()
    {
        return $this->reportsService->orientations();
    }
}
