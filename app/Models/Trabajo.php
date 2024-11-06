<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;

    protected $fillable = [
        'maquina_id',
        'user_id',
        'sucursal_id',
        'almacen_id',
        'cliente_id',
        'vendedor_id',
        'fecha',
        'total',
        'venta',
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class);
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class);
    }

    public function detallesTrabajos()
    {
        return $this->hasMany(DetalleTrabajo::class);
    }
}
