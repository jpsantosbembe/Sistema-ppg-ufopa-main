<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Builder
 */
class Tcc extends Model
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
        'data_defesa' => 'dateformat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_inicio' => 'date:Y-m-d',
        'data_fim' => 'date:Y-m-d',
        'data_defesa' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'id_ppg',
        'codigo_tcc',
        'nome',
        'id_ac',
        'id_linha',
        'id_projeto',
        'id_orientador',
        'id_autor',
        'id_tipo',
        'data_defesa',
        'data_inicio',
        'data_fim',
        'codigo_tcc'
        ];

    public function tipo() : BelongsTo
    {
        return $this->belongsTo(TipoTcc::class, 'id_tipo');
    }

    public function area() : BelongsTo
    {
        return $this->belongsTo(AreaDeConcentracao::class, 'id_ac');
    }

    public function ppg()
    {
        return $this->belongsTo(ProgPosGrad::class, 'id_ppg');
    }
    public function banca() : BelongsToMany
    {
        return $this->belongsToMany(Pessoa::class, 'banca_tccs', 'id_tcc', 'id_pessoa_banca')
            ->using(BancaTcc::class);
    }

    public function orientador() : BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_orientador');
    }
    public function autor() : BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_autor');
    }

    public function linha_pesquisa()
    {
        return $this->belongsTo(LinhaDePesquisa::class, 'id_linha');
    }
    public function financiadores():BelongsToMany
    {
        return $this->belongsToMany(Financiador::class, 'financiadores_tccs', 'id_tcc', 'id_financiador')
            ->using(FinanciadoresTcc::class);
    }

    public function projeto():BelongsTo
    {
        return $this->belongsTo(Projeto::class, 'id_projeto');
    }

}
