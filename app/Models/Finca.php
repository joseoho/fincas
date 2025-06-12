<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Finca extends Model
{
    use HasFactory;
    Protected $primaryKey = "id";
    protected $table ='fincas';
    protected $fillable = [
        'nombre',
        'ubicacion',
        'area',
        'descripcion'
    ];

    /**
     * Relación con los lotes de la finca
     */
    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }

    /**
     * Relación con las transacciones de la finca
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class);
    }

    /**
     * Obtener todos los animales de la finca a través de los lotes
     */
    public function animales()
    {
        return $this->hasManyThrough(
            Animal::class,
            Lote::class
        );
    }
}