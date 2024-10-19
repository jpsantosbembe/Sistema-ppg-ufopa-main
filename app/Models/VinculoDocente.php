<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
/**
 * @mixin Builder
 */
class VinculoDocente extends Model
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
        'data_inicio' => 'date:d/m/Y',
        'data_fim' => 'date:Y-m-d',
    ];

    protected $table = 'vinculos_docentes';

    protected $fillable = [
        'codigo_vinculavel',
        'codigo_lattes',
        'sigla_ies',
        'nome_ies',
        'nivel_titulacao',
        'ano_tit',
        'area_conhecimento_tit',
        'pais_ies_tit',
        'sigla_ies_tit',
        'nome_ies_tit',
        'regime_trabalho',
        'data_inicio',
        'data_fim',
    ];


    public function program():HasOneThrough
    {
        return $this->hasOneThrough(ProgPosGrad::class, Vinculo::class,
            'vinculavel_id',
            'id',
            'id',
            'id_ppg'
        );
    }
    public function vinculo():MorphOne {
        return $this->morphOne(Vinculo::class, 'vinculavel');
    }

    public function categorias() : BelongsToMany{
        return $this->belongsToMany(Categoria::class, 'categorias_docentes','id_vinculo_docente','id_categoria')->using(CategoriaDocente::class);
    }
    public function discentes_orientandos() : BelongsToMany {
        return $this->belongsToMany(VinculoDiscente::class)->using(Orientacao::class);
    }

}
