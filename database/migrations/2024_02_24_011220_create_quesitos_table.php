<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quesitos', function (Blueprint $table) {
            $table->id();
            $table->text('nome');
            $table->unsignedBigInteger('id_coleta');

            $table->foreign('id_coleta')->references('id')
                ->on(\App\Models\Coleta::query()->newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quesitos');
    }
};
