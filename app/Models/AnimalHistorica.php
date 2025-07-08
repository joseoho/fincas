<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalHistorica extends Model
{
    use HasFactory;

    protected $table = 'historial_animals';

    protected $fillable = [
        'lote_id',
        'codigo',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'peso_inicial',
        'estado',
        'observaciones',
        'deleted_by',
        'deleted_reason'
    ];

   protected $dates = ['deleted_at']; // Añade esta línea
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}