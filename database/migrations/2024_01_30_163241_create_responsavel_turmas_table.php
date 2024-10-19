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
        Schema::create('responsavel_turmas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('indicador_resp_principal');
            $table->unsignedBigInteger('id_pessoa');
            $table->unsignedBigInteger('id_turma');
            $table->foreign('id_pessoa')->references('id')->on('pessoas');
            $table->foreign('id_turma')->references('id')->on('turmas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsavel_turmas');
    }
};
