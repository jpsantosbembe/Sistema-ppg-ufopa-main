<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 */
class Coleta extends Model
{
    use HasFactory, HasAttributeAdapter;
    protected array $adapters = [
        'data_envio' => 'datetime_format'
    ];
    protected $fillable = ['data_envio', 'id_ppg', 'ano_calendario'];

    public function ppg() : BelongsTo
    {
        return $this->belongsTo(ProgPosGrad::class, 'id_ppg');
    }
    public function quesitos() : HasMany
    {
        return $this->hasMany(Quesito::class, 'id_coleta');
    }
    protected $casts = [
        'data_envio' => 'datetime'
    ];

}
