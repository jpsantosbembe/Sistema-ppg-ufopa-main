<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin Builder
 */
class Orientacao extends Pivot
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
        'principal' => 'intbool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_inicio' => 'date:Y-m-d',
        'data_fim' => 'date:Y-m-d',
        'principal' => 'boolean',
    ];

    protected $fillable = ['id_vinculo_discente','id_orientador','data_inicio', 'data_fim', 'principal'];
    protected $table = 'orientacoes';
    public $incrementing = true;

    public function discente()
    {
        return $this
            ->belongsTo(VinculoDiscente::class,'id_vinculo_discente')
            ->with([
                'vinculo.programa:id,nome', 'vinculo.pessoa'
            ]);
    }

    public function orientador(){
        return $this->belongsTo(Pessoa::class, 'id_orientador');
    }
}
