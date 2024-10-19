<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vinculos_pos_doc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_vinculavel')->unique();
            $table->string("genero");
            $table->string("sigla_ies");
            $table->string("nome_ies");
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string("sigla_ies_orig")->nullable();
            $table->string("nome_ies_orig")->nullable();
            $table->string("nivel_titulacao");
            $table->string("ano_tit", 4);
            $table->string("area_conhecimento_tit");
            $table->string("pais_ies_tit");
            $table->string("sigla_ies_tit")->nullable();
            $table->string("nome_ies_tit");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vinculos_pos_doc');
    }
};
