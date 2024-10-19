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
        Schema::create('change_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('type', 1); // 'c' - created, 'u' - updated
            $table->mediumText('old_value')->nullable();
            $table->mediumText('new_value')->nullable();
            $table->string('sheet_name');
            $table->unsignedBigInteger('sheet_line');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('upload_id');
            $table->foreign('attribute_id')->references('id')->on('table_attributes');
            $table->foreign('upload_id')->references('id')->on('uploads');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
