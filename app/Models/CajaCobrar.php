<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaCobrar extends Model
{
    use HasFactory;
    protected $fillable = [
        'fechaApertura',
        'totalApertura',
        'fechaCierre',
        'totalCierre',
        'totalGlobalEfectivo',
        'totalGlobalTransferencia',
        'estado',
        'user_id',
        'sucursal_id',
        'observacion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cobros()
    {
        return $this->hasMany(Cobrar::class)->where('estado',1);
    }

    public function calcularBalanceEfectivo()
    {
        $resultado = $this->cobros()
        ->where('medio_id', 1)
        ->where('estado', 1)
        ->selectRaw('SUM(CASE WHEN tipo = 1 THEN total ELSE 0 END) - SUM(CASE WHEN tipo = 0 THEN total ELSE 0 END) as total_1')
        ->value('total_1');

        return $resultado ?? 0;
    }

    public function calcularBalanceTransferencia()
    {
        $resultado = $this->cobros()
        ->where('medio_id', '!=',1)
        ->where('estado', 1)
        ->selectRaw('SUM(CASE WHEN tipo = 1 THEN total ELSE 0 END) - SUM(CASE WHEN tipo = 0 THEN total ELSE 0 END) as total_1')
        ->value('total_1');

        return $resultado ?? 0;
    }
}
