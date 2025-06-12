<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'finca_id',
        'moneda_id',
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'categoria',
        'referencia'
    ];

    /**
     * Relación con la finca
     */
    public function finca(): BelongsTo
    {
        return $this->belongsTo(Finca::class);
    }

    /**
     * Relación con la moneda
     */
    public function moneda(): BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }
}