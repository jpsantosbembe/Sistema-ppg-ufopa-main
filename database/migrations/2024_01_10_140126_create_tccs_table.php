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
        Schema::create('tccs', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('codigo_tcc')->unique();
            $table->foreignIdFor(\App\Models\ProgPosGrad::class, 'id_ppg');
            $table->foreignIdFor(\App\Models\TipoTcc::class, 'id_tipo');
            $table->foreignIdFor(\App\Models\Pessoa::class, 'id_autor');
            $table->foreignIdFor(\App\Models\Pessoa::class, 'id_orientador');
            $table->unsignedBigInteger('id_projeto')->nullable();
            $table->unsignedBigInteger('id_linha')->nullable();
            $table->unsignedBigInteger('id_ac')->nullable();
            $table->date('data_defesa');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tccs');
    }
};
