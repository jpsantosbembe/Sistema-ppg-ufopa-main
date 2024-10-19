<?php

namespace App\Imports\Worksheets;

use App\Imports\util\ModelSaveException;
use App\Imports\util\ModelSaver;
use App\Models\Pessoa;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


abstract class AbstractImport implements OnEachRow, WithHeadingRow
{

    private Upload $upload;
    private string $sheet_name;


    private int $new_records_count = 0;
    private int $updated_records_count = 0;

    public function __construct(Upload $upload, string $sheet_name)
    {
        $this->upload = $upload;
        $this->sheet_name = $sheet_name;
    }

    public function getUpload(): Upload
    {
        return $this->upload;
    }

    public function getSheetName(): string
    {
        return $this->sheet_name;
    }

    public function getNewRecordsCount(): int
    {
        return $this->new_records_count;
    }

    protected function incNewRecordCount() {
        $this->new_records_count++;
    }

    protected function incUpdateRecordCount() {
        $this->updated_records_count++;
    }

    public function getUpdatedRecordsCount(): int
    {
        return $this->updated_records_count;
    }

    abstract function getLabelToLog(): string;

    /**
     * @throws ModelSaveException
     */
    protected function fillAndSave(Model $model, array $data, int $row_index): bool
    {
        $model_saver = ModelSaver::getInstance($model);
        return $model_saver->fillAndSave($model, $data, $this->getSheetName(), $row_index, $this->getUpload());
    }

    protected function log_pessoa(int $row_index, string $op, string $target, Pessoa $pessoa)
    {
        $this->log_info($row_index, $op, $target . " " . $pessoa->nome);
    }

    protected function log_info(int $row_index, string $op, string $info)
    {
        Log::channel('import')->info($this->getLabelToLog() . " |". $op . "| [upload #{$this->upload->id}] (linha: $row_index) ". $info);
    }

    protected function log_error(int $row_index, string $msg)
    {
        Log::channel('import')->error($this->getLabelToLog() . " |err| [upload #{$this->upload->id}] (linha: $row_index) " . $msg);
    }
}
