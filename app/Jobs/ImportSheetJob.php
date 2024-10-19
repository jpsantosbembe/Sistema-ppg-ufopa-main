<?php

namespace App\Jobs;

use App\Exceptions\ImportException;
use App\Imports\SpreadsheetImport;
use App\Models\Upload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected int $type;
    protected string $year;
    protected string $file;
    protected int $user_id;
    public int $timeout = 1800;

    public function getYear(): string
    {
        return $this->year;
    }

    public function getFilePath(): string
    {
        return $this->file;
    }

    public function __construct(string $file, int $type, string $year)
    {
        $this->user_id = auth()->user()->getId();
        $this->file = $file;
        $this->type = $type;
        $this->year = $year;
    }

    /**
     * Execute the job.
     * @throws Throwable
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $this->year = Upload::query()->max('ano') ? Upload::query()->max('ano') + 1 : (int) env('YEAR_INITIAL');
            echo $this->year;
            $sheets_config = Config::get('import.sheets.' . $this->type);
            $sheet = new File(Storage::path($this->file));
            Cache::forever('year_import', $sheet->getFilename());
            $spreadsheet = new SpreadsheetImport($sheets_config, $this->year, $sheet,$this->user_id);
            $spreadsheet->import();

            DB::commit();
            Cache::forget('year_import');
        } catch (Throwable $e) {
            DB::rollBack();
            Cache::forget('year_import');
            throw $e;
        }

    }
}

