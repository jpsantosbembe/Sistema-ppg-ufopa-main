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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ppg');
            $table->unsignedBigInteger('codigo_projeto')->nullable();
            $table->mediumText('nome');
            $table->string('natureza_projeto')->nullable();
            $table->string('situacao')->nullable();
            $table->date('data_situacao')->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable()->nullable();
            $table->unsignedBigInteger('id_ac')->nullable();
            $table->boolean('tem_membro_cad')->default(0);

            $table->foreign('id_ppg')->references('id')->on('ppgs');
            $table->foreign('id_ac')->references('id')->on('area_de_concentracaos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
