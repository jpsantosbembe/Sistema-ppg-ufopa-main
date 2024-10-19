<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaAc extends Model
{
    protected $fillable = ['id_disciplina', 'id_ac'];

    public function ac()
    {
        return $this->belongsTo(AreaDeConcentracao::class, 'id_ac');
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'id_disciplina');
    }

}

