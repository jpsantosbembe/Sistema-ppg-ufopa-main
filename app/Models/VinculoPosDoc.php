<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class VinculoPosDoc extends Model
{
    use HasAttributeAdapter;

    /**
     * Os atributos que precisam de adaptação.
     *
     * @var array
     */
    protected array $adapters = [
        'data_inicio' => 'dateformat',
        'data_fim' => 'dateformat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'vinculo_inicio' => 'date:Y-m-d',
        'vinculo_fim' => 'date:Y-m-d',
    ];

    protected $table = 'vinculos_pos_doc';

    protected $fillable = [
        'codigo_vinculavel',
        'genero',
        'sigla_ies',
        'nome_ies',
        'data_inicio',
        'data_fim',
        'sigla_ies_orig',
        'nome_ies_orig',
        'nivel_titulacao',
        'ano_tit',
        'area_conhecimento_tit',
        'pais_ies_tit',
        'sigla_ies_tit',
        'nome_ies_tit',
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
