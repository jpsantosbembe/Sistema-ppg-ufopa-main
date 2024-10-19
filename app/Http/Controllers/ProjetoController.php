<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\Projeto;
use App\Service\interfaces\IndicadoresProjetosInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProjetoController extends Controller
{

    public function __construct(
        private readonly IndicadoresProjetosInterface $indicadoresProjetos,
    ){}

    public function index()
    {
        $media_projetos_por_pesquisa = $this->indicadoresProjetos->qtde_projetos_ao_decorrer_tempo()->get();
        return Inertia::render('Projeto/index');
    }


    public function show(String $id)
    {
        $projeto = Projeto::where('id',$id)->first();

        if ($projeto === null) {
            return response()->json(['error' => 'Projeto não encontrado'], 404);
        }

        $projeto->load([
            'ppg', 'area_concentracao', 'financiadores',
            'linha_pesquisa' => function (Builder $builder) {
                $builder->where('data_fim','=',null);
            },
            'membros.vinculos' => function (Builder $builder) use($projeto) {
                $builder->where('id_ppg','=',$projeto->id_ppg);
            },
        ]);

//        dd($projeto->membros);
        $membros = $projeto->membros->map(function ($item){
            return [
                'id' => $item->id,
                'nome' => $item->nome,
                'image_path' => $item->image_path,
                'doc' => $item->doc,
                'email' => $item->email,
                'abreviatura' => $item->abreviatura,
                'responsavel' => $item->pivot->membro_responsavel ? 'Sim' : 'Não',
                'vinculo' => $item->pivot->categoria,
            ];
        });


        $financiadores  = $projeto->financiadores->map(function ($item){
            return [
                'id'=>$item->id,
                'nome'=>$item->nome,
                'doc'=>$item->doc ,
                'estrangeiro'=>$item->estrangeiro ? 'Sim' : 'Não',
            ];
        });

        $projeto = $projeto->toArray();
        $projeto['membros'] = $membros;
        $projeto['financiadores'] = $financiadores;
        //return Inertia::render('Projeto/show',compact('projeto'));
        return Inertia::render('Projeto/show',['projeto'=>$projeto]);
    }
}
