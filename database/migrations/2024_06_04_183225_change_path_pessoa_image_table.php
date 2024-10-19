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
        Schema::table('pessoa_images', function (Blueprint $table) {
            $table->string('path')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pessoa_images', function (Blueprint $table) {
            $table->string('path')->default('/assets/images/svgs/icon-user.svg')->change();
        });
    }
};
