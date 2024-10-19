<?php

namespace App\Service;


use App\Models\Disciplina;
use App\Models\Orientacao;
use App\Models\Pessoa;
use App\Models\Producao;
use App\Models\ProgPosGrad;
use App\Models\Projeto;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaginationService
{
    private array $people_filters = ['vinculoDocente','vinculoDiscente','vinculoExterno','vinculoPosDoc','vinculoEgresso'];
    private array $discipline_filters = [true,false];


    public function program(Request $request)
    {
        return (new ProgPosGrad)
            ->withCount(['projetos','vinculoDiscentes','vinculoDocentes','disciplina'])
            ->orderBy('nome')
            ->where(function ($query) use ($request) {
                if ($request->has('people_id')) {
                    $query->whereHas('vinculos', function ($query) use ($request) {
                        $query->where('id_pessoa', $request->input('people_id'));
                    });
                }
                if(request('search')){
                    $query->where('nome','like','%'.request('search').'%');
                }
                if(request('filters')){
                    $query->whereIn('nivel',explode(',', request('filters')));
                }
            })->paginate(32);
    }

    public function upload():LengthAwarePaginator
    {
        return Upload::with('user')->orderByDesc('ano')->paginate(10);
    }

    public function people(Request $request): LengthAwarePaginator
    {
        $query_people = (new Pessoa())->with([
            'vinculos'=>function ($query) {
                if(request('program_id')){
                    $query->where('id_ppg',request('program_id'));
                }
            },
            'image'])->orderBy('nome');

        $query_people = $query_people->where(function($query) use ($request){
            if(request('filters')){
                foreach (explode(',',$request->filters) as $filter){
                    $query->OrHas($this->people_filters[$filter-1]);
                }
            }

            if(request('program_id')){
                $query->withWhereHas('vinculos',function (Builder $builder) {
                        $builder->where('id_ppg','=', request('program_id'));
                    }
                );
            }

            if(!request('person_empty')){
                $query->where('incompleto','=',0);
            }

            $query->where('nome','like','%'.$request->search.'%');

        });
        if(request('project_id')){
            $query_people = $query_people->withWhereHas('projetos',function (Builder $builder) {
                $builder->where('projetos.id','=', request('project_id'));
            }
            );
        }

        return $query_people->paginate(45);
    }

    public function project(Request $request): LengthAwarePaginator{
        $projects = Projeto::query()->with(['membros.image','ppg'])->orderBy('nome');

        $projects = $projects->where(function ($query) use ($request) {
            if(request('program_id')){
                $query->where('id_ppg','=',request('program_id'));
            }

            if ($request->has('people_id')) {
                $query->whereHas('membros', function ($query) use ($request) {
                    $query->where('id_pessoa', $request->input('people_id'));
                });
            }

            if (request('filters_nature')) {
                $query->whereIn('natureza_projeto',explode(',', request('filters_nature')));
            }

            if (request('filters_status')) {
                $query->whereIn('situacao',explode(',', request('filters_status')));
            }

            if (request('filters_belong')) {
                $query->where('tem_membro_cad',request('filters_belong'));
            }
            if(request('search')){
                $query->where('nome','like','%'.request('search').'%');
            }
        });

        $perPage = $request->has('people_id') ? 16 : 54;

        return $projects->paginate($perPage);
    }

    public function discipline(Request $request): LengthAwarePaginator{
        $projects = Disciplina::query()->with([
            'turma.responsavel',
            'curso',
            'area_concentracao'
        ])->orderBy('nome');
        if(isset($request->filters)){
            foreach (explode(',',$request->filters) as $filter){
                $projects = $projects->orWhere('indicador_obrigatoria','=',$this->discipline_filters[$filter-1]);
            }
        }

        if(isset($request->program_id)){
            $projects = $projects->whereHas('curso', function (Builder $builder) use($request) {
                    $builder->where('id_ppg','=', $request->program_id);
            });
        }

        if(isset($request->search)){
            $projects = $projects->where('nome','like','%'.$request->search.'%');
        }

        return $projects->paginate(54);
    }

    public function production(Request $request): LengthAwarePaginator
    {
        $query = Producao::query()
            ->with(['ppg','detalhes','tipo_producao','subtipo_producao','autores','linha_de_pesquisa','qualis'])
            ->orderBy('ano_publicacao', 'desc')
            ->where(function ($query) use($request) {

                if ($request->has('people_id')) {
                    $query->whereHas('autores', function ($query) use ($request) {
                        $query->where('id_pessoa', $request->input('people_id'));
                    });
                }

                if (request('filters_tipo')) {
                    $query->whereIn('id_tipo', explode(',', request('filters_tipo')));
                }

                if (request('filters_subtipo')) {
                    $query->whereIn('id_subtipo', explode(',', request('filters_subtipo')));
                }

                if ($request->has('filters_ano_inicial') && $request->has('filters_ano_final')) {
                    $query->whereBetween('ano_publicacao', [
                        $request->input('filters_ano_inicial'),
                        $request->input('filters_ano_final')
                    ]);
                }

                if (request('search')) {
                    $query->where('nome', 'like', '%' . request('search') . '%');
                }

                if (request('filters_qualis')) {
                    $query->whereHas('qualis', function (Builder $builder) {
                        $builder->whereIn('estratos', explode(',', request('filters_qualis')));
                    });
                }
            });

        $perPage = $request->has('people_id') ? 16 : 135;

        return $query->paginate($perPage);
    }

    public function user(Request $request): LengthAwarePaginator
    {
        $users = User::with(['roles','coordinator']);
        if(isset($request->search)){
            $users = $users->where('nome','like','%'.$request->search.'%');
        }
        return $users->paginate(8 );
    }

    public function oriented(Request $request): LengthAwarePaginator
    {
        $orienteds= Orientacao::query()->with('discente');

        $orienteds = $orienteds->where(function ($orienteds) use ($request){
            $orienteds->where('id_orientador', $request->id_orientador);

            if (request('search')) {
                $orienteds->whereHas('discente', function($subQuery) use ($request) {
                    $subQuery->where('nome', 'like', '%' . request('search') . '%');
                });
            }

        });

        return $orienteds->paginate(16);
    }
}
