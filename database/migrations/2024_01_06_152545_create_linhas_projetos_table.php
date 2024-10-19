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
        Schema::create('linhas_projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_projeto')->nullable();
            $table->unsignedBigInteger('id_lp')->nullable();
            $table->date('data_inicio');
            $table->date('data_final')->nullable();
            $table->foreign('id_projeto')->references('id')->on('projetos');
            $table->foreign('id_lp')->references('id')->on('linhas_de_pesquisas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linhas_projetos');
    }
};
