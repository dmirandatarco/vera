<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobrar extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'medio_id',
        'venta_id',
        'caja_cobrar_id',
        'tipo',
        'fecha',
        'total',
        'operacion',
        'observacion',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medio()
    {
        return $this->belongsTo(Medio::class);
    }
}