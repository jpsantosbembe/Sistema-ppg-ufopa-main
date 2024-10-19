<?php

namespace App\Imports\util;

use App\Models\ChangeLog;
use App\Models\Table;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;

class ModelSaver
{

    private static array $model_savers = [];

    private Table $table;
    private array $map_attrib_to_id;
    private array $map_sheet__to_model;

    /**
     * @throws ModelSaveException
     */
    public static function getInstance(Model $model): ModelSaver
    {
        $table_name = $model->getTable();

        if (!isset(self::$model_savers[$table_name])) {
            self::$model_savers[$table_name] = new ModelSaver($table_name);
        }

        return self::$model_savers[$table_name];
    }

    /**
     * @throws ModelSaveException
     */
    public function fillAndSave(Model $model, array $data, string $sheet_name, int $row_index, Upload $upload): bool
    {
        $old = clone $model;
        $this->modelFill($model, $data);
        if ($saved = $model->isDirty()) {
            $changes = $model->getDirty();
            $model->save();
            $type = ($model->wasRecentlyCreated)?'c':'u';
            $attributes_ids = $this->getArrayMapAttribToId();
            ChangeLog::create_logs($type, $attributes_ids, $old, $changes, $model->id, $sheet_name, $row_index, $upload->id);
        }

        return $saved;
    }

    /**
     * @throws ModelSaveException
     */
    private function __construct(string $table_name)
    {
        $table = Table::where('name' , $table_name)->first();

        if ($table) {
            $this->table = $table;
        } else {
            throw new ModelSaveException("ERRO: Tabela '$table_name' não encontrada no Dicionário de Dados");
        }
    }

    private function getArrayMapAttribToId(): array
    {
        if (! isset($this->map_attrib_to_id)) {
            $table_attributes = $this->table->table_attributes;
            foreach ($table_attributes as $table_attribute) {
                if ($table_attribute->fillable) {
                    $this->map_attrib_to_id[$table_attribute->name] = $table_attribute->id;
                }
            }
        }
        return $this->map_attrib_to_id;
    }

    private function modelFill(Model $model, array $row): Model {
        $data = $this->rowToDataArray($row);
        $model->fill($data);
        return $model;
    }

    private function rowToDataArray(array $row): array {
        $map = $this->getArrayMapSheetToModel();
        $data = [];
        foreach ($map as $attribute => $column) {
            if (array_key_exists($column,  $row)) {
                $data[$attribute] = $row[$column];
            }
        }
        return $data;
    }

    private function getArrayMapSheetToModel(): array
    {
        if (! isset($this->map_sheet__to_model)) {
            $table_attributes = $this->table->table_attributes;

            foreach ($table_attributes as $table_attribute) {
                $this->map_sheet__to_model[$table_attribute->name] = $table_attribute->column;
            }
        }

        return $this->map_sheet__to_model;
    }

}
