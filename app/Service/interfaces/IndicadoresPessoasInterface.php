<?php

namespace App\Service\interfaces;

use App\Models\Pessoa;
use App\Models\VinculoDocente;

interface IndicadoresPessoasInterface
{
 public function qtde_orientados_do_docente($id_pessoa, bool $somente_ativos = false );
}
