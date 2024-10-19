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
        Schema::create('vinculos_egressos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_vinculavel')->unique();
            $table->string("genero");
            $table->string("nivel_titulacao");
            $table->string("data_inicio", 4);
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
        Schema::dropIfExists('vinculos_egressos');
    }
};
