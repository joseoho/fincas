<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
     use HasFactory, SoftDeletes;
  

    protected $fillable = [
        'lote_id',
        'codigo',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'peso_inicial',
        'estado',
        'observaciones',
        'deleted_at'
           ];


    //   protected $dates = ['deleted_at'];
    /**
     * Relación con el lote actual
     */
    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }

    /**
     * Relación con los movimientos del animal
     */
    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoAnimal::class);
    }

    /**
     * Obtener la finca a través del lote
     */
    public function finca()
    {
          return $this->hasOneThrough(
            Finca::class,
            Lote::class,
            'id', // Foreign key on Lote table
            'id', // Foreign key on Finca table
            'lote_id', // Local key on Animal table
            'finca_id' // Local key on Lote table
        );
    }

    public function historial()
{
    return $this->hasMany(AnimalHistorica::class);
}
    
}

