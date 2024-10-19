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
        Schema::create('banca_tccs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tcc::class, 'id_tcc');
            $table->foreignIdFor(\App\Models\Pessoa::class, 'id_pessoa_banca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banca_tccs');
    }
};
