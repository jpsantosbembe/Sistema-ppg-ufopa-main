<?php

namespace App\Service\interfaces;

use Illuminate\Database\Query\Builder;

interface IndicadoresProjetosInterface
{
    public function projetos_sem_linhas_pesquisas() : Builder;
    public function media_projeto_por_linha_pesquisa(mixed $id_ppg): ?float;
    public  function projetos_com_membros_completos(mixed $id_ppg): mixed;
    public function percentual_projetos_financiados(mixed $id_ppg) : ?float;
    public function qtde_projetos_ao_decorrer_tempo(mixed $id_ppg) : Builder;

}
