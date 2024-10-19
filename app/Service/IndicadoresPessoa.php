<?php

namespace App\Service;

use App\Models\Orientacao;
use App\Models\Pessoa;
use App\Service\interfaces\IndicadoresPessoasInterface;
use Illuminate\Database\Eloquent\Builder;

class IndicadoresPessoa implements IndicadoresPessoasInterface
{
    private readonly string $pessoa_table_name;
    public function __construct()
    {
        $this->pessoa_table_name = Pessoa::newModelInstance()->getTable();
    }

    public function qtde_orientados_do_docente($id_pessoa, bool $somente_ativos = false )
    {
        return Orientacao::when($somente_ativos, fn(Builder $query) => $query->where('ativo', '=',1))
        ->where('id_orientador', '=', $id_pessoa)->count();
    }
}
