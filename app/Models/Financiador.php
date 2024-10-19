<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Financiador extends Model
{
    use HasAttributeAdapter;

    /**
     * Os atributos que precisam de adaptação.
     *
     * @var array
     */
    protected array $adapters = [
        'estrangeiro' => 'intbool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'estrangeiro' => 'boolean',
    ];

    protected $table = 'financiadores';
    protected $fillable = ['tipo_doc','doc','nome','estrangeiro'];

    public function tccs() : BelongsToMany
    {
        return $this
            ->belongsToMany(Tcc::class, 'financiadores_tccs', 'id_financiador', 'id_tcc')
            ->using(FinanciadoresTcc::class);
    }

    public function projetos():BelongsToMany
    {
        return $this->belongsToMany(Projeto::class, 'financiadores_projetos', 'id_financiandor', 'id_projeto')
            ->using(FinanciadorProjeto::class);
    }
}
