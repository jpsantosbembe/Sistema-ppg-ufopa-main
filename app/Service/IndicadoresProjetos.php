<?php

namespace App\Service;

use App\Models\AreaDeConcentracao;
use App\Models\FinanciadorProjeto;
use App\Models\LinhaDePesquisa;
use App\Models\LinhaProjeto;
use App\Models\MembroProjeto;
use App\Models\Projeto;
use App\Service\interfaces\IndicadoresProjetosInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;


class IndicadoresProjetos implements IndicadoresProjetosInterface
{
    private readonly string $linha_projeto_table_name;
    private readonly string $linha_pesquisa_table_name;
    private readonly string $projetos_table_name;
    private readonly string $financiadores_projetos_table;
    private readonly string $membros_projetos_table;

    private readonly string $area_concentracao_table;
    public function __construct()
    {
        $this->linha_projeto_table_name = LinhaProjeto::newModelInstance()->getTable();
        $this->linha_pesquisa_table_name = LinhaDePesquisa::query()->newModelInstance()->getTable();
        $this->projetos_table_name = Projeto::newModelInstance()->getTable();
        $this->financiadores_projetos_table = FinanciadorProjeto::newModelInstance()->getTable();
        $this->membros_projetos_table = MembroProjeto::newModelInstance()->getTable();
        $this->area_concentracao_table = AreaDeConcentracao::newModelInstance()->getTable();
    }


    public function projetos_sem_linhas_pesquisas(): Builder
    {
        $nome_tabela = $this->linha_projeto_table_name;
        $tabela_projeto = Projeto::newModelInstance()->getTable();
        $ids = Projeto::query()
            ->leftJoin("$nome_tabela", "$nome_tabela.id_projeto", '=', $tabela_projeto . '.id')
            ->whereNull("$this->linha_projeto_table_name.id_projeto")
            ->selectRaw("$tabela_projeto.id AS id")->get();
        return Projeto::whereIn('id', $ids->map(fn($_IH_Projeto_QB) => $_IH_Projeto_QB->id))->getQuery();
    }

    public function media_projeto_por_linha_pesquisa($id_ppg = null): ?float
    {
        return DB::query()
            ->fromSub(function (\Illuminate\Database\Query\Builder $query) use ($id_ppg) {
                return $query->selectRaw('COUNT(DISTINCT jp.id) AS counter_projetos')
                    ->from($this->linha_pesquisa_table_name, 'lpe')
                    ->join($this->linha_projeto_table_name . ' AS lpo', 'lpo.id_lp', '=', 'lpe.id')
                    ->join($this->projetos_table_name . ' AS jp', 'jp.id', '=', "lpo.id_projeto")
                    ->when($id_ppg, function (Builder $query) use ($id_ppg) {
                        return $query->where('jp.id_ppg', '=', $id_ppg);
                    })
                    ->groupBy('lpe.id');
            }, 'sb1')
            ->avg('sb1.counter_projetos');
    }
    public function projetos_com_membros_completos($id_ppg = null): mixed
    {
        return Projeto::join(
            $this->membros_projetos_table,
            $this->membros_projetos_table . '.id_projeto',
            '=',
            $this->projetos_table_name . '.id'
        )
            ->join('pessoas', 'pessoas.id', '=', 'membros_projetos.id_pessoa')
            ->select(['projetos.*'])
            ->distinct()
            ->when($id_ppg, function (Builder $query) use ($id_ppg) {
                $query->where('projetos.id_ppg', '=', $id_ppg);
            })
            ->where('pessoas.incompleto', '=', 0);

    }

    public function percentual_projetos_financiados($id_ppg = null): ?float
    {
        return DB::table($this->projetos_table_name, 'pj')
            ->selectRaw('(sb1.financiados / (sb1.financiados + sb1.sem_financiamento)) * 100 AS taxa_financiamento')
            ->fromSub(function ($query) use ($id_ppg) {
                $query->selectRaw(' SUM(CASE WHEN fp.id IS NOT NULL THEN 1 ELSE 0 END) AS financiados,
                                    SUM(CASE WHEN fp.id IS NULL THEN 1 ELSE 0 END) AS sem_financiamento')
                    ->from($this->projetos_table_name, 'pj')
                    ->leftJoin($this->financiadores_projetos_table . ' AS fp', 'fp.id_projeto', '=', 'pj.id')
                    ->when($id_ppg, function (Builder $query) use ($id_ppg) {
                        $query->where('id_ppg', '=', $id_ppg);
                    });
            }, 'sb1')
            ->first()->taxa_financiamento;
    }

    public function qtde_projetos_por_ano($id_ppg = null): Builder
    {
        $subqueryConcluidos = DB::table($this->projetos_table_name, 'pj')
            ->selectRaw('YEAR(pj.data_situacao) as ano, COUNT(*) AS qtde_concluidos')
            ->whereDate('pj.data_situacao', '>=', '2013-01-01')
            ->where('pj.situacao', 'CONCLUÍDO')
            ->groupByRaw('YEAR(pj.data_situacao)');

        $subqueryIniciados = DB::table($this->projetos_table_name, 'pj')
            ->selectRaw('YEAR(pj.data_inicio) as ano, COUNT(*) AS qtde_iniciados')
            ->whereDate('pj.data_inicio', '>=', '2013-01-01')
            ->groupByRaw('YEAR(pj.data_inicio)');

        if ($id_ppg) {
            $subqueryConcluidos->where('pj.id_ppg', '=', $id_ppg);
            $subqueryIniciados->where('pj.id_ppg', '=', $id_ppg);
        }

        return DB::table(DB::raw("({$subqueryIniciados->toSql()}) as iniciados"))
            ->selectRaw('iniciados.ano, iniciados.qtde_iniciados, COALESCE(concluidos.qtde_concluidos, 0) as qtde_concluidos')
            ->leftJoin(DB::raw("({$subqueryConcluidos->toSql()}) as concluidos"), 'iniciados.ano', '=', 'concluidos.ano')
            ->mergeBindings($subqueryIniciados)
            ->mergeBindings($subqueryConcluidos)
            ->orderBy('iniciados.ano');
    }


    public function qtde_projetos_concluido_ao_decorrer_tempo($id_ppg = null): Builder
    {
        return DB::table($this->projetos_table_name, 'pj')
            ->selectRaw('COUNT(*) AS qtde, YEAR(pj.data_situacao) as ano')
            ->groupByRaw('YEAR(pj.data_situacao)')
            ->orderByRaw('YEAR(pj.data_situacao)')
            ->whereDate('pj.data_situacao', '>=', '2013-01-01')
            ->where('pj.situacao','CONCLUÍDO')
            ->when($id_ppg, fn(Builder $query) => $query->where('pj.id_ppg', '=', $id_ppg));
    }

    public function qtde_projetos_ao_decorrer_tempo($id_ppg = null): Builder
    {
        return DB::table($this->projetos_table_name, 'pj')
            ->selectRaw('COUNT(*) AS qtde, YEAR(pj.data_inicio) as ano')
            ->groupByRaw('YEAR(pj.data_inicio)')
            ->orderByRaw('YEAR(pj.data_inicio)')
            ->whereDate('pj.data_inicio', '>=', '2013-01-01')
            ->when($id_ppg, fn(Builder $query) => $query->where('pj.id_ppg', '=', $id_ppg));
    }

    public function qtde_pessoas_linha_pesquisa($id_ppg = null): Builder
    {
        return DB::table('membros_projetos')
            ->selectRaw('count(*) as qtde, linhas_de_pesquisas.nome, linhas_de_pesquisas.id')
            ->join('projetos', 'projetos.id', '=', 'membros_projetos.id_projeto')
            ->join('linhas_projetos', 'linhas_projetos.id_projeto', '=', 'projetos.id')
            ->join('linhas_de_pesquisas', 'linhas_de_pesquisas.id', '=', 'linhas_projetos.id_lp')
            ->when($id_ppg, fn(Builder $query) => $query->where('projetos.id_ppg', '=', $id_ppg))
            ->orderByDesc('qtde')
            ->groupBy('linhas_de_pesquisas.nome', 'linhas_de_pesquisas.id');
    }
}
