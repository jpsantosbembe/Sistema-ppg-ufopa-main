<?php

namespace App\Http\Controllers;


use App\Models\LinhaDePesquisa;
use App\Models\ProgPosGrad;
use App\Models\Projeto;
use App\Models\SubTipoProducao;
use App\Models\TipoProducao;
use App\Providers\RouteServiceProvider;
use App\Service\IndicadoresProducao;
use App\Service\interfaces\IndicadoresProducaoInterface;
use App\Service\interfaces\IndicadoresProjetosInterface;
use App\Service\interfaces\IndicadoresVinculosInterface;
use Carbon\Carbon;
use \Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProgramaController extends Controller
{
    public function __construct(
        private readonly IndicadoresProjetosInterface $indicadoresProjetos,
        private readonly IndicadoresVinculosInterface $indicadoresVinculos,
        private readonly IndicadoresProducaoInterface $indicadoresProducao
    ){}

    public function index()
    {
        return Inertia::render('Programa/index');
    }

    public function show(String $id)
    {
        $user = Auth::user();
        if ($user->hasRole('Coordenador') and $user->coordinator->ppg->id != $id) {
            return redirect(RouteServiceProvider::PROGRAM . '/' . $user->coordinator->ppg->id);

        }

        $programa = (new ProgPosGrad)
            ->with(relations: [
                'linhas'=>function (Builder $builder) {
                    $builder->withCount('projetos')->with('area')
                    ->with('projetos');
                },
                'tccs'=>function (Builder $builder) {
                    $builder->with('autor');
                },
                'proposta',
            ])
            ->withCount('producoes')
            ->withCount('disciplina')
            ->withCount('projetos')
            ->withCount('pessoas')
            ->findOrFail($id);

        $indicadores = [
            'percentual_proj_financiados' => $this->indicadoresProjetos->percentual_projetos_financiados($id),
            'media_projetos_por_pesquisa' => $this->indicadoresProjetos->media_projeto_por_linha_pesquisa($id),
            'qtde_por_ano_projetos' => $this->indicadoresProjetos->qtde_projetos_ao_decorrer_tempo($id)->get(),
            'qtde_por_ano_egressos' => $this->indicadoresVinculos->egressos_decorrer_tempo($id)->get(),
            'qtde_pessoas_linha_pesquisa' => $this->indicadoresProjetos->qtde_pessoas_linha_pesquisa($id)->get(),
            'qtde_producao_com_qualis'=>$this->indicadoresProducao->qtde_producoes_com_qualis(null,$id)->count(),
            'qtde_producao_por_qualis'=> $this->indicadoresProducao->qtde_producoes_por_qualis(null,$id)
        ];

        $linhas = $programa->linhas->map(function ($item) use ($programa){
            return [
                'id'=>$item->id,
                'nome'=>mb_strimwidth(strtoupper($item->nome),0,135,'...'),
                'area'=>strtoupper($item->area?->nome),
                'projetos_count'=>LinhaDePesquisa::query()->whereHas('projetos',function ($query) use($programa){
                    $query->where('id_ppg',$programa->id);
                })->count(),
                'pessoa_by_line'=>array_reduce($item->projetos->toArray(),function ($carry, $item){
                   return $carry + $item['membros_count'];
                },0),
                'data_inicio'=> Carbon::parse($item->data_inicio)->format('d/m/Y') ,
                'data_fim'=> $item->data_fim ? Carbon::parse($item->data_fim)->format('d/m/Y'): '--'
            ];
        });

        $qualis = $indicadores['qtde_producao_por_qualis']->pluck('estratos')->toArray();
        $indicadores['qtde_producao_por_qualis'] = $indicadores['qtde_producao_por_qualis']->toArray();

        $programa = $programa->toArray();
        $programa['linhas'] = $linhas;
        $programa['indicadores'] = $indicadores;
        $tiposProduction = TipoProducao::get();
        $subtiposProductions  = SubTipoProducao::get();
        return Inertia::render('Programa/show',
            compact('programa','tiposProduction','subtiposProductions','qualis'));
    }

    public function search(Request $request)
    {
        $ppgs = ProgPosGrad::query();
        if(is_null($request->search)){
            $ppgs = $ppgs->where('nome','like', '%'.$request->search.'%');
        }
        $ppgs = $ppgs->get()->map(function ($item){
           return[
               'id'=>$item->id,
               'nome'=>$item->nome,
           ];
        });
        return response()->json($ppgs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_ppg'=>'required',
            'nome'=>'required',
            'area_avaliacao'=>'required',
            'sigla_ies'=>'required',
            'nome_ies'=>'required',
            'nivel'=>'required',

        ]);
        $programa = (new ProgPosGrad);
        $programa->fill($validated);
        $programa->save();

        return back()->with('success', 'Programa cadastrado com sucesso!');
    }

    public function projetos(String $id)
    {
        $projetos = (new Projeto)
            ->withCount('membros')
            ->where('id_ppg',$id)
            ->get()->map(function ($item){
                return [
                    'id'=>strtoupper($item->id),
                    'nome'=>strtoupper($item->nome),
                    'natureza'=>$item->natureza_projeto,
                    'situacao'=>$item->situacao,
                    'membros_count'=> $item->membros_count
                ];
            });

        return $projetos;
    }
}
