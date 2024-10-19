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
        Schema::create('categorias_docentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vinculo_docente');
            $table->unsignedBigInteger('id_categoria');
            $table->date("data_inicio");
            $table->date("data_fim")->nullable();
            $table->integer("ch");
            $table->boolean('ativo')->default(1);
            $table->timestamps();
            $table->foreign('id_vinculo_docente')->references('id')->on('vinculos_docentes');
            $table->foreign('id_categoria')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias_docentes');
    }
};
