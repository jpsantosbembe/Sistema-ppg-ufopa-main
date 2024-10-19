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
        Schema::create('qualis', function (Blueprint $table) {
            $table->string('issn')->unique();
            $table->string('titulo');
            $table->string('estratos');
            $table->string('area_de_avaliacao');
            $table->primary('issn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualis');
    }
};
