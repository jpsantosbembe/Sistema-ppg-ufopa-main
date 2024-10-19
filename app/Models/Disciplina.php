<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disciplina extends Model
{
    use HasAttributeAdapter;

    protected array $adapters = [
        'data_inicio' => 'dateformat',
        'data_fim' => 'dateformat',
        'indicador_obrigatoria' => 'intbool',
    ];

    protected $casts = [
        'data_inicio' => 'date:Y-m-d',
        'data_fim' => 'date:Y-m-d',
        'indicador_obrigatoria' => 'boolean',
    ];

    protected $fillable = ['codigo_disciplina', 'nome', 'sigla','ch', 'data_inicio', 'data_fim', 'qtd_creditos', 'indicador_obrigatoria', 'numero', 'id_curso'];

    public function turma(): HasMany
    {
        return $this->hasMany(Turma::class, 'id_disciplina');
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function area_concentracao(){
        return $this->hasOneThrough(AreaDeConcentracao::class,DisciplinaAc::class, 'id_disciplina','id','id','id_ac');
    }

}
