<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property  int id
 * @property string nome
 * @mixin Builder
 */
class Projeto extends Model
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
        'tem_membro_cad' => 'intbool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_inicio' => 'date:Y-m-d',
        'data_situacao' => 'date:Y-m-d',
        'tem_membro_cad' => 'boolean',
    ];

    protected $fillable = [
        'id_ppg',
        'id_ac',
        'codigo_projeto',
        'nome',
        'natureza_projeto',
        'situacao',
        'data_situacao',
        'data_inicio',
        'data_fim',
        'tem_membro_cad',
    ];

    public function financiadores(): BelongsToMany
    {
        return $this->belongsToMany(Financiador::class, 'financiadores_projetos', 'id_projeto', 'id_financiador')
            ->using(FinanciadorProjeto::class);
    }


    public function linha_pesquisa() :BelongsToMany
    {
        return $this->belongsToMany(LinhaDePesquisa::class, 'linhas_projetos', 'id_projeto', 'id_lp')
            ->using(LinhaProjeto::class);
    }

    public function ppg(): BelongsTo
    {
        return $this->belongsTo(ProgPosGrad::class, 'id_ppg');
    }

    public function area_concentracao(): BelongsTo
    {
        return $this->belongsTo(AreaDeConcentracao::class, 'id_ac');
    }

    public function tccs(): HasMany
    {
        return $this->hasMany(Tcc::class, 'id_projeto');
    }

    public function membros(): BelongsToMany
    {
        return $this->belongsToMany(Pessoa::class, 'membros_projetos', 'id_projeto', 'id_pessoa')
            ->using(MembroProjeto::class)->withPivot('membro_responsavel','categoria');
    }
}
