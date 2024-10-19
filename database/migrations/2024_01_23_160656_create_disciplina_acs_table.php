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
        Schema::create('disciplina_acs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_disciplina');
            $table->unsignedBigInteger('id_ac')->nullable();
            $table->foreign('id_disciplina')->references('id')->on('disciplinas');
            $table->foreign('id_ac')->references('id')->on('area_de_concentracaos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplina_acs');
    }
};
