<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin Builder
 */
class Vinculo extends Model
{
    protected $fillable = ['id_pessoa', 'id_ppg', 'ativo'];

   
    public function vinculavel() : MorphTo {
        return $this->morphTo(__FUNCTION__, 'vinculavel_type', 'vinculavel_id');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class,'id_pessoa');
    }

    public function programa():BelongsTo
    {
        return $this->belongsTo(ProgPosGrad::class,'id_ppg');
    }
}
