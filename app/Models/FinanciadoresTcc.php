<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * @mixin Builder
 */
class FinanciadoresTcc extends Model
{
    use HasFactory;
    use AsPivot;
    protected $table = 'financiadores_tccs';
    protected $fillable = ['id_tcc', 'id_financiador', 'nome_prog_fomento', 'qtd_meses'];
}
