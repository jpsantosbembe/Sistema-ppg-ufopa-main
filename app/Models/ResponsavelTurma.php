<?php

namespace App\Models;

use App\Imports\Concerns\HasAttributeAdapter;
use Illuminate\Database\Eloquent\Model;

class ResponsavelTurma extends Model
{
    use HasAttributeAdapter;

    protected array $adapters = [
        'indicador_resp_principal' => 'intbool',
    ];

    protected $casts = [
        'indicador_resp_principal' => 'boolean',
    ];

    protected $fillable = ['indicador_resp_principal', 'id_pessoa', 'id_turma'];

    public function Pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }
}
