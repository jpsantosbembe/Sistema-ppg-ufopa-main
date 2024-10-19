<?php

namespace App\Utils\DashboardObserver;

use App\Models\Dashboard;
use App\Models\VinculoDiscente;
use Illuminate\Support\Facades\DB;

class ProcessarDados
{
    public static function processarDadosAlunos($alunos)
    {
        $resultadosPais = [];

        foreach ($alunos as $estudante) {
            $codigoPais = Paises::obterCodigoPais($estudante['vinculo']['pessoa']['pais']);
            $statusAtivo = $estudante['vinculo']['ativo'];

            if (!isset($resultadosPais[$codigoPais])) {
                $resultadosPais[$codigoPais] = ['ativos' => 0, 'inativos' => 0];
            }

            if ($statusAtivo) {
                $resultadosPais[$codigoPais]['ativos']++;
            } else {
                $resultadosPais[$codigoPais]['inativos']++;
            }
        }

        return $resultadosPais;
    }

    public static function processarMovimentacaoDiscente()
    {
        $egressos = VinculoDiscente::select(
            DB::raw('EXTRACT(YEAR FROM data_situacao) as ano_situacao'),
            DB::raw('count(*) as total')
        )
            ->whereNot('nivel','=', 'Bacharelado')
            ->whereIn('situacao', ['TITULADO'])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM data_situacao)'))
            ->get();



        $desligados = VinculoDiscente::select(
            DB::raw('EXTRACT(YEAR FROM data_situacao) as ano_situacao'),
            DB::raw('count(*) as total')
        )
            ->whereNot('nivel','=', 'Bacharelado')
            ->whereIn('situacao', ['DESLIGADO'])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM data_situacao)'))
            ->get();

        $abandonos = VinculoDiscente::select(
            DB::raw('EXTRACT(YEAR FROM data_situacao) as ano_situacao'),
            DB::raw('count(*) as total')
        )
            ->whereNot('nivel','=', 'Bacharelado')
            ->whereIn('situacao', ['ABANDONOU'])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM data_situacao)'))
            ->get();

        // Obter os resultados dos ingressos
        $ingressos = VinculoDiscente::select(
            DB::raw('EXTRACT(YEAR FROM data_inicio) as date_year'),
            DB::raw('count(*) as total')
        )
            ->whereNot('nivel','=', 'Bacharelado')
            ->groupBy(DB::raw('EXTRACT(YEAR FROM data_inicio)'))
            ->get();

        // Transformar os resultados em arrays associativos para facilitar a manipulação
        $egressosArray = $egressos->mapWithKeys(function ($item) {
            return [$item->ano_situacao => $item->total];
        })->toArray();

        $desligadosArray = $desligados->mapWithKeys(function ($item) {
            return [$item->ano_situacao => $item->total];
        })->toArray();

        $abandonosArray = $abandonos->mapWithKeys(function ($item) {
            return [$item->ano_situacao => $item->total];
        })->toArray();

        $ingressosArray = $ingressos->mapWithKeys(function ($item) {
            return [$item->date_year => $item->total];
        })->toArray();

        // Combinar os resultados em um único array
        $resultadoFinal = [];

        $anos = array_unique(array_merge(array_keys($ingressosArray), array_keys($egressosArray)));
        sort($anos);


        foreach ($anos as $ano) {
            $resultadoFinal[$ano] = [
                'ingressos' => $ingressosArray[$ano] ?? 0,
                'egressos' => $egressosArray[$ano] ?? 0,
                'desligados' => $desligadosArray[$ano] ?? 0,
                'abandonos' => $abandonosArray[$ano] ?? 0,
            ];



            $ativos_ano_anterior = array_key_exists($ano - 1, $resultadoFinal) ? $resultadoFinal[$ano - 1]['ativos'] : 0;
//            dd($ativos_ano_anterior);
            $resultadoFinal[$ano]["ativos"] = $ativos_ano_anterior + $resultadoFinal[$ano]["ingressos"] - $resultadoFinal[$ano]["egressos"] - $resultadoFinal[$ano]["desligados"] - $resultadoFinal[$ano]["abandonos"];
        }
//        dd($resultadoFinal,$anos);
        return $resultadoFinal;
    }

}
