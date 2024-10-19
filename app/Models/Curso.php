<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = ['codigo_curso', 'nome', 'id_ppg', 'id_nivel'];

    public function disciplina(): HasMany
    {
        return $this->hasMany(Disciplina::class,'id_curso')->withCount('turma');
    }
}
