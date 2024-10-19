<?php

use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $db = config('database.default');
        $filename = __dir__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR  . $db . DIRECTORY_SEPARATOR . 'up.sql';
        if (file_exists($filename)) {
            DB::unprepared( file_get_contents($filename) );
        } else {
            throw new ErrorException("Script não encontrado: '$filename'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $db = env('DB_CONNECTION');
        $filename = __dir__ . '/../sql/' . $db . '/down.sql';
        if (file_exists($filename)) {
            DB::unprepared( file_get_contents($filename) );
        } else {
            throw new ErrorException("Script não encontrado: '$filename'");
        }
    }
};
