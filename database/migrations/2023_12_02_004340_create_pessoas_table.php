<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new   class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_pessoa')->unique();
            $table->string("nome");
            $table->boolean('incompleto')->default(0);
            $table->string("tipo_doc")->nullable();
            $table->string("doc")->nullable();
            $table->string("abreviatura")->nullable();
            $table->string("nacionalidade")->nullable();
            $table->string("pais")->nullable();
            $table->string("orcid")->nullable();
            $table->date("data_nascimento")->nullable();
            $table->string('lattes')->nullable();
            $table->string("email")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};
