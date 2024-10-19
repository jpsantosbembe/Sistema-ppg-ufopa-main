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
        Schema::create('vinculos_discentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_vinculavel')->unique();
            $table->string("genero");
            $table->string("raca_cor")->nullable();
            $table->boolean("portador_deficiencia");
            $table->string("nivel");
            $table->string("situacao");
            $table->date('data_inicio');
            $table->date('data_situacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vinculos_discentes');
    }
};
