<?php

namespace App\Service\interfaces;

use Illuminate\Database\Eloquent\Builder;

interface IndicadoresTCCInterface
{
    public function tccs(): Builder;
    public function tccs_do_projeto(mixed $id_projeto);
    public function tccs_apenas_com_finanaciadores();

}
