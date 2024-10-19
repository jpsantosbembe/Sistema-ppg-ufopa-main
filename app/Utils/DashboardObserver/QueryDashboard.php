<?php

namespace App\Utils\DashboardObserver;

use App\Models\Dashboard;
use App\Models\VinculoDiscente;
use PhpParser\Node\Stmt\TryCatch;

class QueryDashboard
{
    public static function obterAnosDeInicio()
    {
        return VinculoDiscente::selectRaw('extract(year from data_inicio) as ano')
            ->groupByRaw('extract(year from data_inicio)')
            ->get()
            ->toArray();
    }

    public static function obterAlunosPorAno($ano)
    {
        return VinculoDiscente::with('vinculo.pessoa')
            ->whereYear('data_inicio', $ano)
            ->get()
            ->toArray();
    }

    public static function atualizarDashboard($dadosAnuais, $discentes_ano, $qtde_por_ano_projetos)
    {
        foreach ($dadosAnuais as $ano => $dadosPais) {
            Dashboard::updateOrCreate(
                ['ano' => $ano],
                ['mapa_pais' => $dadosPais],
            );
        }

        foreach ($discentes_ano as $ano => $discente) {
            // dd($ano, $discente);
            Dashboard::updateOrCreate(
                ['ano' => $ano],
                ['grafico_entrando_saindo' => $discente],
            );
        }

        // dd($qtde_por_ano_projetos);

        foreach ($qtde_por_ano_projetos as $item) {
            Dashboard::updateOrCreate(
                ['ano' => $item->ano],
                ['projetos_ano' => [
                    'started'=>$item->qtde_iniciados,
                    'finished'=>$item->qtde_concluidos,
                ]],
            );
        }
    }

}
