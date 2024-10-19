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
        Schema::create('financiadores_projetos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_projeto');
            $table->unsignedBigInteger('id_financiador');
            $table->string('natureza');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->foreign('id_projeto')->references('id')->on('projetos');
            $table->foreign('id_financiador')->references('id')->on('financiadores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financiadores_projetos');
    }
};
