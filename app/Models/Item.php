<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 */
class Item extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'conteudo', 'id_quesito'];
    public function quesito():BelongsTo
    {
        return $this->belongsTo(Quesito::class, 'id_quesito');
    }
}
