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
        Schema::create('detalhes_producoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producao');
            $table->string('item');
            $table->mediumText('valor_item');
            $table->foreign('id_producao')->references('id')->on('producoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalhes_producoes');
    }
};
