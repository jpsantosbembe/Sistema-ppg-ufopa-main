<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaImage extends Model
{
    use HasFactory;

    protected $fillable = ['id_pessoa', 'path'];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class,'id_pessoa');
    }
}
