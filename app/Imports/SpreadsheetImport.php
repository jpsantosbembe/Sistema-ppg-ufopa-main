<?php

namespace App\Imports;



use App\Exceptions\ImportException;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class SpreadsheetImport implements WithMultipleSheets
{
    private array $sheets;
    private File $file;
    private int $user_id;
    private Upload $upload;

    /**
     * @throws ImportException
     */
    public function __construct(array $sheets_config, int $ano,  $file, int $user_id) {
        DB::beginTransaction();
        $this->user_id = $user_id;
        $this->file =  $file;
        $this->upload = $this->create_upload($ano, $file);
        $this->sheets = $this->sheetsToImport($sheets_config);
    }

    public function import():Upload
    {
        Excel::import($this, $this->file, null, \Maatwebsite\Excel\Excel::XLSX);

        $this->update_upload();
        return $this->upload;
    }

    public function sheets(): array
    {
        return $this->sheets;
    }

    /**
     * @throws ImportException
     */
    private function sheetsToImport(array $sheets_config): array
    {
        $sheets = [];

        try {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($this->file);
        } catch (Exception $e) {
            throw new ImportException($e);
        }

        foreach($sheets_config as $item){
            $sheet = $spreadsheet->getSheetByName($item['sheet_name']);
            if ($sheet) {
                if ($sheet->getHighestRow() > 1) {
                    $import_class = $item['import_class'];
                    $importer = new $import_class($this->upload, $item['sheet_name']);
                    $sheets[ $item['sheet_name'] ] = $importer;

                }
            } else {
                DB::rollBack();
                throw new ImportException("ERRO: Aba '{$item['sheet_name']}' não encontrada na planilha '{$this->upload->original_file_name}'");
            }
        }

        DB::commit();
        return $sheets;
    }

    private function updateProgress($progress)
    {
        Cache::put('import_progress', $progress, now()->addMinutes(10)); // Por exemplo, armazenar o progresso na cache por 10 minutos
    }

    /**
     * @throws ImportException
     */
    private function create_upload(int $ano, File $file): Upload
    {
        $hash = hash_file('md5', $file->getPathname());
        if (! Upload::where('file_hash', $hash)->exists()) {
            $upload = new Upload([
                'ano' => $ano,
                'upload_date' => Carbon::now(),
                'original_file_name' => $file->getFilename(),
                'file_path' => $file->getPathname(),
                'file_hash' => $hash,
                'status_id' => Upload::UNPROCESSED,
                'user_id' => $this->user_id,
            ]);
            $upload->save();
        } else {
            throw new ImportException("'ERRO: Uma planilha idêntica à essa foi importada anteriormente'");
        }
        return $upload;
    }

    private function update_upload()
    {
        $path = Storage::putFileAs('file/planilhas', $this->file, $this->upload->file_hash);

        $this->upload->file_path = $path;
        $this->upload->status_id = Upload::SUCCESS;
        $this->upload->result = $this->getImportResult();
        $this->upload->save();
    }

    private function getNewRecordsCount(): int
    {
        $count = 0;
        foreach ($this->sheets as $sheet) {
            $count = $count + $sheet->getNewRecordsCount();
        }
        return $count;
    }

    private function getUpdatedRecordsCount(): int
    {
        $count = 0;
        foreach ($this->sheets as $sheet) {
            $count = $count + $sheet->getUpdatedRecordsCount();
        }
        return $count;
    }

    public function getImportResult(): string
    {
        $result = "";
        foreach ($this->sheets as $key=>$sheet) {
            $result .= $key .  ": {$sheet->getNewRecordsCount()} registros novo(s), {$sheet->getUpdatedRecordsCount()} atualizado(s)\n";
        }
        return $result;
    }
}
