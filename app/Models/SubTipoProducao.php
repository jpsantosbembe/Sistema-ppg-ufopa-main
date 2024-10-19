<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubTipoProducao extends Model
{
    use HasFactory;
    protected $table = 'subtipos_producoes';
    protected $fillable = ['nome'];
    public function producoes():HasMany
    {
        return $this->hasMany(Producao::class, 'id_subtipo');
    }
}
