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
        Schema::create('producoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ppg');
            $table->unsignedBigInteger('id_tipo')->nullable();
            $table->unsignedBigInteger('id_subtipo')->nullable();
            $table->unsignedBigInteger('id_lp')->nullable();
            $table->unsignedBigInteger('id_projeto')->nullable();
            $table->unsignedBigInteger('codigo_producao');
            $table->mediumText('nome');
            $table->string('ano_publicacao');
            $table->boolean('cinco_mais_relevante');
            $table->foreign('id_ppg')->references('id')->on('ppgs');
            $table->foreign('id_tipo')->references('id')->on('tipos_producoes');
            $table->foreign('id_subtipo')->references('id')->on('subtipos_producoes');
            $table->foreign('id_lp')->references('id')->on('linhas_de_pesquisas');
            $table->foreign('id_projeto')->references('id')->on('projetos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producoes');
    }
};
