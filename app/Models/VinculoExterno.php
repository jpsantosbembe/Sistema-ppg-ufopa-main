<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Builder
 */
class VinculoExterno extends Model
{
    protected $table = 'vinculos_externos';

    protected $fillable = [
        'codigo_vinculavel',
        'genero',
        'pais_ies_orig',
        'nome_ies_orig',
        'tipo_participacao',
        'nivel_titulacao',
        'area_conhecimento_tit',
        'pais_ies_tit',
        'nome_ies_tit',
        'ano_tit',
    ];


    public function vinculo():MorphOne {
        return $this->morphOne(Vinculo::class, 'vinculavel');
    }

    public function program():HasOneThrough
    {
        return $this->HasOneThrough(ProgPosGrad::class, Vinculo::class,
            'vinculavel_id',
            'id',
            'id',
            'id_ppg'
        );
    }

}
