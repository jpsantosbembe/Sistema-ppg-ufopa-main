<?php

namespace App\Service;

use App\Models\Vinculo;
use App\Models\VinculoEgresso;
use App\Service\interfaces\IndicadoresVinculosInterface;
use Illuminate\Database\Query\Builder;

class IndicadoresVinculos implements IndicadoresVinculosInterface
{

    public function egressos_decorrer_tempo(mixed $id_ppg = null)
    {

        return Vinculo::selectRaw('COUNT(*) AS qtde, data_inicio AS ano')
            ->join('vinculos_egressos', function ($join) {
                $join->on('vinculos.vinculavel_id', '=', 'vinculos_egressos.id')
                    ->where('vinculos.vinculavel_type', '=', 'App\\Models\\VinculoEgresso');
            })
            ->when($id_ppg, fn ($query) => $query->where('vinculos.id_ppg', $id_ppg))
            ->groupBy('data_inicio')
            ->orderBy('data_inicio');
    }
}
