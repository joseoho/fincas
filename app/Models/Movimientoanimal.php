<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoAnimal extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'lote_anterior_id',
        'lote_nuevo_id',
        'motivo',
        'fecha'
    ];

    /**
     * Relación con el animal
     */
   public function animal()
{
    return $this->belongsTo(Animal::class);
}

public function loteOrigen()
{
    return $this->belongsTo(Lote::class, 'lote_anterior_id');
}

public function loteDestino()
{
    return $this->belongsTo(Lote::class, 'lote_nuevo_id');
}
}