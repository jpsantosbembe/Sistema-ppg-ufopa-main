<?php

namespace App\Http\Controllers;

use App\Exports\QualisByProgramExport;
use App\Models\ProgPosGrad;
use App\Models\Producao;
use App\Models\Qualis;
use App\Models\SubTipoProducao;
use App\Models\TipoProducao;
use App\Models\VinculoDiscente;
use App\Models\VinculoDocente;
use App\Models\VinculoExterno;
use App\Models\VinculoPosDoc;
use App\Service\interfaces\IndicadoresProducaoInterface;
use App\Service\Reports;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProducaoController extends Controller
{

    public function __construct(
        private readonly IndicadoresProducaoInterface $indicadoresProducao,
        private readonly Reports $reportsService,
    ){}

    function index(): Response
    {
        $tipos = TipoProducao::get();
        $subtipos  = SubTipoProducao::get();

        $qualis = Qualis::query()
            ->select('estratos')
            ->distinct()->orderBy('estratos')
            ->get()->pluck('estratos')->toArray();

        return Inertia::render('Producao/Index',compact('tipos','subtipos', 'qualis'));
    }

    function qualis( $project)
    {
        return response($this->indicadoresProducao->qtde_producoes_por_qualis(null,$project, request('ano')));
    }

    function reportByProgram()
    {
        return $this->reportsService->qualis();
    }

    function exportData(): BinaryFileResponse
    {
        $data = $this->reportsService->qualis();
        $info = (object)[
            'program'=>ProgPosGrad::find(request('program_id'))?->nome,
            'year'=>request('year_published'),
        ];

        return Excel::download(
            new QualisByProgramExport($data,$info),
            'relatorio_qualis_'.Str::slug($info->program).'_'.$info->year.'.xlsx'
        );
    }
}

