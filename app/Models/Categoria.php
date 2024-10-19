<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Builder
 */
class Categoria extends Model
{
    protected $fillable = ['nome'];

    public function docentes():BelongsToMany {
        return $this->belongsToMany(VinculoDocente::class, 'categorias_docentes')->using(CategoriaDocente::class);
    }
}
