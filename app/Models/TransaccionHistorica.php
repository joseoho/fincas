<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TransaccionHistorica extends Model
{
  use SoftDeletes, HasFactory;

    protected $table = 'historial_transaccions';

    protected $fillable = [
        'id',
        'finca_id',
        'moneda_id',
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'categoria',
        'referencia',
        'deleted_by',
        'delete_reason'
    ];

    // Relaciones
    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class);
    }

    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}