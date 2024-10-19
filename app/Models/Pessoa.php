<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @mixin Builder
 *
 * @property int id
 * @property string nome
 */
class Pessoa extends Model
{
    use HasAttributeAdapter;

    /**
     * Os atributos que precisam de adaptação.
     *
     * @var array
     */
    protected array $adapters = [
        'data_nascimento' => 'dateformat',
        'incompleto' => 'intbool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_nascimento' => 'date:Y-m-d',
        'incompleto' => 'boolean',
    ];

    protected $appends = ['image_path'];
    protected $fillable = [
        'codigo_pessoa',
        'nome',
        'tipo_doc',
        'doc',
        'nacionalidade',
        'data_nascimento',
        'pais',
        'orcid',
        'lattes',
        'email',
        'abreviatura',
        'incompleto',
    ];


    protected function getImagePathAttribute()
    {
        $image = $this->image;
        return $image?->path ?: '/assets/images/svgs/icon-user.svg';
    }
    public function image(): HasOne
    {
        return $this->hasOne(PessoaImage::class,'id_pessoa');
    }
    protected function dataNascimento():Attribute{
        return Attribute::make(
            get: fn (?string $value) => $value ? Carbon::parse($value)->format('d/m/Y') : '---'
        );
    }

    public function tcc(): HasOne
    {
        return $this->hasOne(Tcc::class, 'id_autor');
    }


    public function autorProducao(): HasMany
    {
        return $this->hasMany(AutorProducao::class, 'id_pessoa', 'id');
    }
//    public function vinculoDiscente(): HasOneThrough
//    {
//        return $this->hasVinculo(VinculoDiscente::class);
//    }

    public function vinculoDiscente(): HasOne
    {
        return $this->hasOne(VinculoDiscente::class, 'id', 'id_vinculo_discente');
    }

    public function vinculoDocente(): HasOneThrough
    {
        return $this->hasVinculo(VinculoDocente::class);
    }

    public function vinculoExterno(): HasOneThrough
    {
        return $this->hasVinculo(VinculoExterno::class);
    }

    public function vinculoEgresso(): HasOneThrough
    {
        return $this->hasVinculo(VinculoEgresso::class);
    }

    public function vinculoPosDoc(): HasOneThrough
    {
        return $this->hasVinculo(VinculoPosDoc::class);
    }

    public function vinculos(): HasMany
    {
        return $this->hasMany(Vinculo::class, 'id_pessoa');
    }


    private function hasVinculo(string $class): HasOneThrough
    {
        return $this->hasOneThrough(
            $class,
            Vinculo::class,
            'id_pessoa',
            'id',
            'id',
            'vinculavel_id'
        )->where('vinculavel_type', $class);
    }
    public function bancas(): BelongsToMany
    {
        return $this->belongsToMany(Tcc::class, 'banca_tccs', 'id_pessoa_banca', 'id_tcc')
            ->using(BancaTcc::class);
    }

    public function orientacoes()
    {
        return $this->hasMany(Orientacao::class, 'id_orientador');
    }

    public function producoes(): BelongsToMany
    {
        return $this->belongsToMany(Producao::class, 'autores_producoes', 'id_pessoa', 'id_producao')
            ->using(AutorProducao::class)
            ->withPivot('nome_autor', 'ordem');
    }

    public function projetos(): BelongsToMany
    {
        return $this->belongsToMany(Projeto::class, 'membros_projetos', 'id_pessoa', 'id_projeto')
            ->using(MembroProjeto::class)
            ->withPivot(['data_inicio','data_fim','membro_responsavel','categoria']);
    }
}
