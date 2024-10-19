<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalheProducao extends Model
{
    use HasFactory;
    protected $table = 'detalhes_producoes';
    protected $fillable =['id_producao','item','valor_item'];

    public function producao() : BelongsTo
    {
        return $this->belongsTo(Producao::class,'id_producao');
    }
}
