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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('codigo_curso')->unique();
            $table->string('nome');
            $table->unsignedBigInteger('id_ppg');
            $table->unsignedBigInteger('id_nivel');
            $table->foreign('id_ppg')->references('id')->on('ppgs');
            $table->foreign('id_nivel')->references('id')->on('nivel_cursos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
