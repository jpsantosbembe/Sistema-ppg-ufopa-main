<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AutorProducao extends Model
{
    use AsPivot;
    protected $table = 'autores_producoes';
    protected $fillable = ['id_producao','id_pessoa', 'nome_autor', 'ordem','categoria'];


    public function producoes()
    {
        return $this->belongsTo(Producao::class,'id_producao');
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

}
