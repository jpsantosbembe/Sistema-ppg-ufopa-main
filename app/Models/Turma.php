<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = ['codigo_turma', 'nome', 'periodoAno', 'id_disciplina'];

    public function responsavel()
    {
        return $this->hasMany(ResponsavelTurma::class,'id_turma')->with(['pessoa']);
    }
}
