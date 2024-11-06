<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medio_id',
        'venta_id',
        'compra_id',
        'caja_id',
        'tipo',
        'fecha',
        'total',
        'documento',
        'operacion',
        'observacion',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medio()
    {
        return $this->belongsTo(Medio::class);
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
