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
        Schema::create('membros_projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pessoa');
            $table->unsignedBigInteger('id_projeto');
            $table->unsignedBigInteger('vinculo_id')->nullable();
            $table->boolean('membro_responsavel');
            $table->string('categoria');
            $table->date("data_inicio");
            $table->date('data_fim')->nullable();
            $table->foreign('vinculo_id')->references('id')->on('vinculos');
            $table->foreign('id_pessoa')->references('id')->on('pessoas');
            $table->foreign('id_projeto')->references('id')->on('projetos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membros_projetos');
    }
};
