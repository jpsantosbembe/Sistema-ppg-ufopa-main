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
        Schema::create('coletas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_envio');
            $table->year('ano_calendario');
            $table->unsignedBigInteger('id_ppg');

            $table->foreign('id_ppg')->references('id')
                ->on(\App\Models\ProgPosGrad::query()->newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coletas');
    }
};
