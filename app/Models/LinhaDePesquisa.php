<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property int id
 * @property string nome
 *
 */
class LinhaDePesquisa extends Model
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
        'data_inicio' => 'date:Y-m-d',
        'data_fim' => 'date:Y-m-d',
    ];

    protected $table = 'linhas_de_pesquisas';

    protected $fillable = ['codigo_lp','id_ppg','nome','data_inicio','data_fim', 'id_ac'];

    public function tccs(): HasMany
    {
        return $this->hasMany(Tcc::class, 'id_linha');
    }

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'linhas_projetos', 'id_lp', 'id_projeto')
            ->using(LinhaProjeto::class)->withCount('membros');
    }

    public function area():BelongsTo
    {
        return $this->belongsTo(AreaDeConcentracao::class,'id_ac');
    }
}
