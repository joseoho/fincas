<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'finca_id',
        'nombre',
        'proposito',
        'capacidad_maxima',
        'descripcion'
    ];

    /**
     * Relación con la finca
     */
    public function finca(): BelongsTo
    {
        return $this->belongsTo(Finca::class);
    }

    /**
     * Relación con los animales del lote
     */
    public function animales(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    /**
     * Relación con los movimientos donde este lote es el origen
     */
    public function movimientosOrigen(): HasMany
    {
        return $this->hasMany(MovimientoAnimal::class, 'lote_anterior_id');
    }

    /**
     * Relación con los movimientos donde este lote es el destino
     */
    public function movimientosDestino(): HasMany
    {
        return $this->hasMany(MovimientoAnimal::class, 'lote_nuevo_id');
    }
}