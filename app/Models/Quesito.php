<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 */
class Quesito extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'id_coleta'];
    public function coleta():BelongsTo
    {
        return $this->belongsTo(Coleta::class, 'id_coleta');
    }
    public function itens()
    {
        return $this->hasMany(Item::class, 'id_quesito');
    }
}
