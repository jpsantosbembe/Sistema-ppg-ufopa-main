<?php

namespace App\Service;

use App\Models\Tcc;
use App\Service\interfaces\IndicadoresTCCInterface;
use Illuminate\Database\Eloquent\Builder;

class IndicadoresTCC implements IndicadoresTCCInterface
{
    public function tccs() : Builder
    {
        return Tcc::with([
            'projeto' => function ($query) {
                $query->with(['financiadores', 'linha_pesquisa' ]);
            },
            'orientador',
            'linha_pesquisa',
            'autor',
            'tipo'
        ]);
    }

    public function tccs_do_projeto(mixed $id_projeto)
    {
        return Tcc::where('id_projeto', '=', $id_projeto);
    }

    public function tccs_apenas_com_finanaciadores() : Builder
    {
        return Tcc::with(['financiadores'])->join('financiadores_tccs AS fc', 'fc.id_tcc', '=', 'tccs.id');
    }
}
