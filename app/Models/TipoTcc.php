<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 */
class TipoTcc extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function tccs(): HasMany
    {
        return $this->hasMany(Tcc::class, 'id_tipo');
    }
}
