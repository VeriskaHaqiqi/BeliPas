<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataImport extends Model
{
    protected $fillable = [
        'uploaded_by',
        'original_filename',
        'file_path',
        'status',
        'total_rows',
        'inserted_rows',
        'updated_rows',
        'rejected_rows',
        'error_summary',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'total_rows' => 'integer',
            'inserted_rows' => 'integer',
            'updated_rows' => 'integer',
            'rejected_rows' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function priceRecords(): HasMany
    {
        return $this->hasMany(PriceRecord::class, 'data_import_id');
    }
}
