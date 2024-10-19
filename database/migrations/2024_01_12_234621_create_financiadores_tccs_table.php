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
        Schema::create('financiadores_tccs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tcc::class, 'id_tcc')->constrained('tccs');
            $table->foreignIdFor(\App\Models\Financiador::class, 'id_financiador')->constrained('financiadores');
            $table->string('nome_prog_fomento');
            $table->integer('qtd_meses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financiadores_tccs');
    }
};
