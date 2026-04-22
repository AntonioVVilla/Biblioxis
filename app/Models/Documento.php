<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'tipo',
        'ruta_archivo',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Documento $documento) {
            try {
                if ($documento->ruta_archivo && Storage::disk('private')->exists($documento->ruta_archivo)) {
                    Storage::disk('private')->delete($documento->ruta_archivo);
                }
            } catch (\Throwable $e) {
                Log::error('No se pudo eliminar el archivo asociado al documento', [
                    'documento_id' => $documento->id,
                    'error' => $e->getMessage(),
                ]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfType($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
