<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string result
 *
 */
class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'ano',
        'upload_date',
        'original_file_name',
        'file_path',
        'file_hash',
        'result',
        'user_id',
        'status_id'];

    // UPLOAD TYPES
    public const ALL_DATATABLE  = 1; // Importação completa da tabela
    public const DEVELOP_TESTE = 2; // USAR DURANTE A CRIAÇÃO DA IMPORTAÇÃO



    // UPLOAD STATUSES
    public const UNPROCESSED = 1;
    public const PROCESSING = 2;
    public const ERROR = 3;
    public const ALERT = 4;
    public const SUCCESS = 5;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
