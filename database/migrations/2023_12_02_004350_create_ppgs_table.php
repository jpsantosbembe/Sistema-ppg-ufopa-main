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
        Schema::create('ppgs', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_ppg')->unique();
            $table->string('nome');
            $table->string('area_avaliacao');
            $table->string('sigla_ies');
            $table->string('nome_ies');
            $table->string('nivel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppgs');
    }
};
