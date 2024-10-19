<?php

namespace App\Observers;

use App\Models\Upload;
use App\Models\VinculoDiscente;
use App\Service\IndicadoresProjetos;
use App\Utils\DashboardObserver\ProcessarDados;
use App\Utils\DashboardObserver\QueryDashboard;

class UploadObserver
{
    /**
     * Handle the Upload "created" event.
     */
    public function created(Upload $upload): void
    {
    }

    /**
     * Handle the Upload "updated" event.
     */
    public function updated(?Upload $upload): void
    {
        $anos = QueryDashboard::obterAnosDeInicio();
        $resultadosAnuais = [];
//        dd($anos);

        foreach ($anos as $ano) {
            $alunos = QueryDashboard::obterAlunosPorAno($ano['ano']);
            $resultadosAnuais[$ano['ano']] = ProcessarDados::processarDadosAlunos($alunos);
        }

        $discentes_ano = ProcessarDados::processarMovimentacaoDiscente();
//        dd($discentes_ano);

        $indicadoresProjetos = new IndicadoresProjetos();
        $qtde_por_ano_projetos = $indicadoresProjetos->qtde_projetos_por_ano()->get()->toArray();

        QueryDashboard::atualizarDashboard($resultadosAnuais, $discentes_ano, $qtde_por_ano_projetos);
    }

    /**
     * Handle the Upload "deleted" event.
     */
    public function deleted(Upload $upload): void
    {
    }

    /**
     * Handle the Upload "restored" event.
     */
    public function restored(Upload $upload): void
    {
    }

    /**
     * Handle the Upload "force deleted" event.
     */
    public function forceDeleted(Upload $upload): void
    {
        //
    }
}
