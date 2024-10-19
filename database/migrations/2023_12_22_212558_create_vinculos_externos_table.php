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
        Schema::create('vinculos_externos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_vinculavel')->unique();
            $table->string("genero");
            $table->string("pais_ies_orig")->nullable();
            $table->string("nome_ies_orig")->nullable();
            $table->string("tipo_participacao");
            $table->string("nivel_titulacao")->nullable();
            $table->string("area_conhecimento_tit")->nullable();
            $table->string("nome_ies_tit")->nullable();
            $table->string("ano_tit", 4)->nullable();
            $table->string("pais_ies_tit")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vinculos_externos');
    }
};
