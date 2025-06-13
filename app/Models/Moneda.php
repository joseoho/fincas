<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Moneda extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'tipo',
        'simbolo'
    ];

    /**
     * Relación con las transacciones
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class);
    }
}