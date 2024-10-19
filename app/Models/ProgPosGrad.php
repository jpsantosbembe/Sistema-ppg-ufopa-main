<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @mixin Builder
 */
class ProgPosGrad extends Model
{
    protected $table = 'ppgs';
    protected $fillable = ['codigo_ppg', 'nome', 'area_avaliacao', 'sigla_ies', 'nome_ies','nivel'];


    public function pessoas()
    {
        return $this->hasManyThrough(Pessoa::class, Vinculo::class,'id_ppg','id','id','id_pessoa');
    }

    public function projetos(): HasMany
    {
        return $this->hasMany(Projeto::class,'id_ppg');
    }

    public function vinculoDiscentes():HasManyThrough
    {
        return $this->hasManyVinculo(VinculoDiscente::class);
    }

    public function vinculoDocentes():HasManyThrough
    {
        return $this->hasManyVinculo(VinculoDocente::class);
    }

    private function hasManyVinculo(String $class):HasManyThrough
    {
        return $this->hasManyThrough(
            VinculoDiscente::class,
            Vinculo::class,
            'id_ppg',
            'id',
            'id',
            'vinculavel_id'
        )->where('vinculavel_type',$class);
    }

    public function tccs() : HasMany
    {
        return $this->hasMany(Tcc::class, 'id_ppg');
    }

    public function producoes(): HasMany{
        return $this->hasMany(Producao::class, 'id_ppg');
    }

    public function linhas(): HasMany
    {
        return $this->hasMany(LinhaDePesquisa::class,'id_ppg');
    }

    public function curso(): HasMany
    {
        return $this->hasMany(Curso::class,'id_ppg');
    }

    public function disciplina()
    {
        return $this->hasManyThrough(Disciplina::class, Curso::class,'id_ppg','id_curso')->withCount('turma');
    }

    public function proposta()
    {
        return $this->hasMany(Coleta::class, 'id_ppg')->with('quesitos.itens')->orderBy('created_at','desc');
    }

}
