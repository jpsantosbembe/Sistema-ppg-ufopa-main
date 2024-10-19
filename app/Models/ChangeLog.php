<?php

namespace App\Models;

use App\Imports\util\ModelSaveException;
use App\Imports\util\ModelSaver;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'old_value', 'new_value', 'model_id', 'sheet_name', 'sheet_line', 'attribute_id', 'upload_id'];

    /**
     * @throws ModelSaveException
     */
    public static function create_logs(string $type, array $attributes_ids, Model $old, array $changes, int $model_id, string $sheet_name, int $row_index, int $upload_id)
    {
        try {
            foreach($changes as $key => $value){
                if (isset($attributes_ids[$key])) {
                    $change_log = ChangeLog::create([
                        'type' => $type,
                        'old_value' => $old->getAttributeValue($key),
                        'new_value' => $value,
                        'model_id' => $model_id,
                        'sheet_name' => $sheet_name,
                        'sheet_line' => $row_index,
                        'attribute_id' => $attributes_ids[$key],
                        'upload_id' => $upload_id
                    ]);
                    $change_log->save();
                }
            }
        } catch (Exception $e) {
            throw new ModelSaveException($e);
        }
    }

}
