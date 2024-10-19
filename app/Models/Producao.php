<?php

namespace App\Models;


use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @mixin Builder
 *  */
class Producao extends Model
{
    use HasAttributeAdapter;
    use HasFactory;

    /**
     * Os atributos que precisam de adaptação.
     *
     * @var array
     */
    protected array $adapters = [
        'cinco_mais_relevante' => 'intbool'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cinco_mais_relevante' => 'boolean',
    ];

    protected $table = 'producoes';
    protected $fillable = [
        'id_ppg',
        'id_tipo',
        'id_subtipo',
        'id_lp',
        'id_projeto',
        'codigo_producao',
        'nome',
        'ano_publicacao',
        'cinco_mais_relevante',
        'issn',
        'estrato'
    ];

    public function detalhes(): HasMany
    {
        return $this->hasMany(DetalheProducao::class, 'id_producao');
    }

    public function tipo_producao()
    {
        return $this->belongsTo(TipoProducao::class, 'id_tipo');
    }

    public function subtipo_producao(){
        return $this->belongsTo(SubTipoProducao::class, 'id_subtipo');
    }
    public function ppg()
    {
        return  $this->belongsTo(ProgPosGrad::class, 'id_ppg');
    }

    public function autores(): BelongsToMany {
        return $this->belongsToMany(Pessoa::class, 'autores_producoes', 'id_producao', 'id_pessoa')
            ->withPivot('nome_autor','ordem','categoria');
    }

    public function linha_de_pesquisa(): BelongsTo
    {
        return $this->belongsTo(LinhaDePesquisa::class,'id_lp');
    }

    public function qualis(): BelongsTo
    {
        return $this->belongsTo(Qualis::class, 'issn','issn');
    }
}
