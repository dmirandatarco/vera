<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'almacen_id',
        'proveedor_id',
        'fecha',
        'numero',
        'total',
        'compra',
    ];

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

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class);
    }

    public function detallesTickets()
    {
        return $this->hasMany(DetalleTicket::class);
    }
}
