<?php

namespace App\Http\Controllers;

use App\Models\MembroProjeto;
use App\Models\Orientacao;
use App\Models\Pessoa;
use App\Models\PessoaImage;
use App\Models\Producao;
use App\Models\ProgPosGrad;
use App\Models\SubTipoProducao;
use App\Models\TipoProducao;
use App\Service\interfaces\IndicadoresPessoasInterface;
use App\Service\interfaces\IndicadoresProducaoInterface;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Qualis;

class PessoaController extends Controller
{

    public function __construct(
        private readonly IndicadoresProducaoInterface $indicadoresProducao,
        private readonly IndicadoresPessoasInterface $indicadoresPessoas
    )
    {
    }

    public function index(): Response
    {
        return Inertia::render('Pessoas/index');
    }

    public function show(string $id)
    {
        $pessoa = (new Pessoa)
            ->with([
                'vinculos'=>function ($builder) {
                    $builder->with(['vinculavel', 'programa']);
                },
                'producoes' => function ($query) {
                    $query->with([
                        'autores',
                        'tipo_producao',
                        'subtipo_producao'
                    ])->orderBy('ano_publicacao', 'desc');
                },
                'producoes.qualis',
                'projetos.membros.image',
                'tcc'=>function($builder){
                    $builder->with(['ppg','tipo','banca','orientador','linha_pesquisa','projeto','area']);
                }
            ])
            ->withCount('orientacoes')
            ->findOrFail($id);

        if($pessoa->incompleto){
            $programa  = MembroProjeto::with('projetos.ppg')->where(
                ['id_pessoa'=>$pessoa->id]
            )->get()->map(fn($item)=>(object)[
                'ppg' => $item->projetos->ppg,
                'vinculavel_type' => $item->categoria,
            ])->unique('ppg.id');
            $vinculos = $programa->map(function ($item){
                return [
                    'id'=>$item->ppg->id,
                    'programa' =>strtoupper($item->ppg->nome),
                    'sigla_ies' =>$item->ppg->sigla_ies,
                    'regime_trabalho' =>'--',
                    'data_inicio' =>'--',
                    'data_fim' => '--',
                    'vinculavel_type' => $item->vinculavel_type,
                    'nivel'=> $item->ppg->nivel
                ];
            });
        }else{
            $vinculos = $pessoa->vinculos->map(function ($item) {
                $vinculavel_type = substr(explode('\\', $item->vinculavel_type)[2], 7);
                $categoria = null;
                $ch = null;

                if ($vinculavel_type == 'Docente') {
                    $categoriaDocente = $item->vinculavel->categorias()
                        ->withPivot('ch')
                        ->latest('id')
                        ->first();

                    if ($categoriaDocente) {
                        $categoria = $categoriaDocente;
                        $ch = $categoriaDocente->pivot->ch;
                    }
                }

                return [
                    'id' => $item->programa->id,
                    'programa' => strtoupper($item->programa->nome),
                    'sigla_ies' => $item->programa->sigla_ies,
                    'regime_trabalho' => $item->vinculavel->regime_trabalho ?? '--',
                    'categoria' => $categoria?->nome ?? '--',
                    'ch' => $ch ?? '--',
                    'data_inicio' => $vinculavel_type == 'Egresso'
                        ? $item->vinculavel->data_inicio
                        : ($item->vinculavel->data_inicio
                            ? (new DateTime($item->vinculavel->data_inicio))->format('Y-m-d')
                            : null),
                    'data_fim' => $this->adapterDateFim($item->vinculavel, $vinculavel_type),
                    'vinculavel_type' => $vinculavel_type,
                    'nivel' => $item->programa->nivel
                ];
            });

            $vinculos = $vinculos->sortBy('data_fim')->values();

        }

        $id_pessoa = $pessoa->id;
        $pessoa = $pessoa->toArray();

        $tipos = TipoProducao::select('nome','id')->whereHas('producoes.autores', function($query) use ($id_pessoa) {
            $query->where('id_pessoa', $id_pessoa);
        })->distinct()->orderBy('nome')->get()->toArray();

        $subtipos = SubTipoProducao::select('nome','id')->whereHas('producoes.autores', function($query) use ($id_pessoa) {
            $query->where('id_pessoa', $id_pessoa);
        })->distinct()->orderBy('nome')->get()->toArray();

        $qualis = Producao::query()->select('qualis.estratos')
            ->join('qualis', 'producoes.issn', '=', 'qualis.issn')
            ->whereHas('autores', function($query) use ($id_pessoa) {
                $query->where('id_pessoa', $id_pessoa);
            })
            ->distinct()->orderBy('qualis.estratos')->get()->pluck('estratos')->toArray();

        $anos = Producao::query()->select('ano_publicacao')
            ->whereHas('autores', function($query) use ($id_pessoa) {
                $query->where('id_pessoa', $id_pessoa);
            })
            ->distinct()->orderBy('ano_publicacao', 'desc')->pluck('ano_publicacao')->toArray();
//        ->distinct()->orderBy('ano_publicacao', 'desc')->pluck('ano_publicacao')->toArray();
        $ppgs = ProgPosGrad::select('nome','id')->whereHas('producoes.autores', function($query) use ($id_pessoa) {
            $query->where('id_pessoa', $id_pessoa);
        })->distinct()->orderBy('nome')->get()->toArray();

        $pessoa['prod_bibliograficas_count'] = $this->indicadoresProducao->qtde_producoes_bibliograficas($id_pessoa);
        $pessoa['prod_tecnicas_count'] = $this->indicadoresProducao->qtde_producoes_tecnicas($id_pessoa);
        $pessoa['orientacoes_count'] = $this->indicadoresPessoas->qtde_orientados_do_docente($id_pessoa);
        $pessoa['orientacoes_ativas_count'] = $this->indicadoresPessoas->qtde_orientados_do_docente($id_pessoa, true);
        $pessoa['vinculos'] = $vinculos;

        return Inertia::render('Pessoas/show',['people'=>$pessoa,'tiposProduction'=>$tipos,'subtiposProductions'=>$subtipos, 'qualis'=>$qualis, 'anos'=>$anos, 'ppgs'=>$ppgs ] ) ;
    }

    public function update(String $id, Request $request)
    {
        $pessoa = Pessoa::with('image')->findOrFail($id);
        $data=[];

        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/images', $pessoa->id . '.' . $extension);
            $data['path'] = str_replace('public','/storage',$imagePath);
            PessoaImage::updateOrCreate(
                [
                    'id_pessoa'=>$pessoa->id
                ],
                [
                    'id_pessoa'=>$pessoa->id,
                    'path'=>$data['path']
                ]
            );
        }

        return back();
    }

    public function adapterDateFim($vinculavel, $typeVinculo)
    {

        return match ($typeVinculo) {
            "Docente" => $vinculavel->data_fim ? Carbon::parse($vinculavel->data_fim)->format('d/m/Y') : "--",
            "Discente" => $vinculavel->getDataFim(),
            "PosDoc" => "--",
            default => "--",
        };
    }

    public function orientadores()
    {
        $programId = request('program_id');
        $token = request('search');
       return Orientacao::query()
            ->join('pessoas as op', 'op.id', '=', 'orientacoes.id_orientador')
            ->join('vinculos as v', function($join) {
                $join->on('v.vinculavel_id', '=', 'orientacoes.id_vinculo_discente')
                    ->where('v.vinculavel_type', '=', 'App\\Models\\VinculoDiscente');
            })
            ->join('pessoas as dp', 'dp.id', '=', 'v.id_pessoa')
            ->when($programId, function ($query) use ($programId) {
                $query
                    ->join('ppgs', 'ppgs.id', '=', 'v.id_ppg')
                    ->where('ppgs.id', $programId);
            })
            ->when($token, function ($query) use ($token) {
                $query->where('op.nome', 'like', '%'.$token.'%');
            })
            ->select('op.id','op.nome',)
            ->distinct()->get();
    }
}
