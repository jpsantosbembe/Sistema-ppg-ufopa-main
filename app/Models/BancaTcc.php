<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin Builder
 */
class BancaTcc extends Model
{
    use AsPivot;
    protected $table = 'banca_tccs';
    protected $fillable = ['id_tcc', 'id_pessoa_banca'];
}
