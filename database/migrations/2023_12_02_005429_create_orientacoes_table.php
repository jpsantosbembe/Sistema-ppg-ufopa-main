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
        Schema::create('orientacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vinculo_discente');
            $table->unsignedBigInteger('id_orientador');
            $table->date("data_inicio");
            $table->date("data_fim")->nullable();
            $table->boolean("principal");
            $table->boolean("ativo")->default(1);
            $table->timestamps();
            $table->foreign('id_vinculo_discente')->references('id')->on('vinculos_discentes');
            $table->foreign('id_orientador')->references('id')->on('pessoas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientacoes');
    }
};
