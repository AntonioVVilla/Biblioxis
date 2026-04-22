<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Carpeta extends Model
{
    use HasFactory;

    protected $table = 'carpetas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documentos(): BelongsToMany
    {
        return $this->belongsToMany(Documento::class, 'documento_carpeta')
            ->withTimestamps();
    }
}
