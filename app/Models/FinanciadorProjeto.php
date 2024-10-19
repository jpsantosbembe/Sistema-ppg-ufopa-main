<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

class FinanciadorProjeto extends Model
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

    protected $table = 'financiadores_projetos';
    protected $fillable = ['id_projeto','id_financiador','natureza','data_inicio','data_fim'];
}
