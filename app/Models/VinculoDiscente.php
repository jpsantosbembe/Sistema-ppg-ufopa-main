<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Date;

/**
 * @mixin Builder
 * @property int $id
 */
class VinculoDiscente extends Model
{
    use HasAttributeAdapter;

    /**
     * Os atributos que precisam de adaptação.
     *
     * @var array
     */
    protected array $adapters = [
        'data_inicio' => 'dateformat',
        'data_situacao' => 'dateformat',
        'portador_deficiencia' => 'intbool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_inicio' => 'date:Y-m-d',
        'data_situacao' => 'date:Y-m-d',
        'portador_deficiencia' => 'boolean',
    ];

    protected $table = 'vinculos_discentes';

    protected $fillable = ['codigo_vinculavel', 'genero', 'raca_cor', 'portador_deficiencia', 'nivel', 'situacao', 'data_inicio', 'data_situacao'];

    public function getDataFim()
    {
        if($this->situacao !== 'MATRICULADO'){
            return Carbon::parse($this->data_situacao)->format('d/m/Y');
        }
        return '---';
    }

    public function vinculo():MorphOne {
        return $this->morphOne(Vinculo::class, 'vinculavel');
    }

    public function orientadores() : BelongsToMany {
        return $this->belongsToMany(VinculoDocente::class)->using(Orientacao::class);
    }

    public function orientacao()
    {
        return $this->belongsTo(Orientacao::class, 'id_vinculo_discente');
    }
}
