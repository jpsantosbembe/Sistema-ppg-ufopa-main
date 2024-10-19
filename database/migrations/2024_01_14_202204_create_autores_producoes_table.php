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
        Schema::create('autores_producoes', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('ordem');
            $table->unsignedBigInteger('id_producao');
            $table->unsignedBigInteger('id_pessoa');
            $table->string('categoria');
            $table->string('nome_autor')->nullable();
            $table->foreign('id_producao')->references('id')->on('producoes');
            $table->foreign('id_pessoa')->references('id')->on('pessoas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autores_producoes');
    }
};
