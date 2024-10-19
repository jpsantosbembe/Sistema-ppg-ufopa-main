<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $table = 'dashboard';

    protected $fillable = [
        'mapa_pais',
        'grafico_entrando_saindo',
        'projetos_ano',
        'ano'
    ];

    public function getProjetosAnoAttribute($value)
    {
        if (is_null($value))
            return null;

        return json_decode($value, true);
    }

    public function setProjetosAnoAttribute($value)
    {
        $this->attributes['projetos_ano'] = json_encode($value);
    }
    public function getGraficoEntrandoSaindoAttribute($value)
    {
        if (is_null($value))
            return null;

        return json_decode($value, true);
    }

    public function setGraficoEntrandoSaindoAttribute($value)
    {
        $this->attributes['grafico_entrando_saindo'] = json_encode($value);
    }

    public function getMapaPaisAttribute($value)
    {
        if (is_null($value))
            return null;

        return json_decode($value, true);
    }

    public function setMapaPaisAttribute($value)
    {
        $this->attributes['mapa_pais'] = json_encode($value);
    }

}
