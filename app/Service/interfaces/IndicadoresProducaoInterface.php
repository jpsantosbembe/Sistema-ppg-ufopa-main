<?php

namespace App\Service\interfaces;

use App\Models\VinculoDiscente;
use App\Models\VinculoDocente;

interface IndicadoresProducaoInterface
{
    public function qtde_producoes_tecnicas( mixed $id_pessoa, mixed $id_ppg = null);
    public function qtde_producoes_bibliograficas(mixed $id_pessoa, mixed $id_ppg = null);
}
