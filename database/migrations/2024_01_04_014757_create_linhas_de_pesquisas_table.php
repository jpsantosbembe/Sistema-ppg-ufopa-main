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
        Schema::create('linhas_de_pesquisas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_lp');
            $table->unsignedBigInteger('id_ppg')->nullable();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->unsignedBigInteger('id_ac')->nullable();
            $table->foreign('id_ac')->references('id')->on('area_de_concentracaos');
            $table->foreign('id_ppg')->references('id')->on('ppgs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linhas_de_pesquisas');
    }
};
