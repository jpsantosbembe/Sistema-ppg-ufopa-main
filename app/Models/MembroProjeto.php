<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MembroProjeto extends Model
{
    use AsPivot;
    use HasAttributeAdapter;

    /**
     * Os atributos que precisam de adaptação.
     *
     * @var array
     */
    protected array $adapters = [
        'data_inicio' => 'dateformat',
        'data_fim' => 'dateformat',
        'membro_responsavel' => 'intbool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_inicio' => 'date:Y-m-d',
        'data_fim' => 'date:Y-m-d',
        'membro_responsavel' => 'boolean',
    ];

    protected $table = 'membros_projetos';
    protected $fillable = ['id_pessoa','id_projeto','vinculo_id','membro_responsavel','categoria','data_inicio','data_fim'];

    public function projetos(): BelongsTo
    {
        return $this->belongsTo(Projeto::class,'id_projeto');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }
}
