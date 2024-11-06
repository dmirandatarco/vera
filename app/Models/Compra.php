<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_id',
        'almacen_id',
        'user_id',
        'proveedor_id',
        'documento_id',
        'nume_doc',
        'fecha',
        'acuenta',
        'saldo',
        'total',
        'estadoPagado',
    ];
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function detallesCompra()
    {
        return $this->hasMany(DetalleCompra::class);
    }
    public function pagosCompra()
    {
        return $this->hasMany(Pago::class);
    }
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function verPago()
    {
        $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();

        $resultado = $this->pagosCompra()
        ->where('estado', 1)
        ->where('caja_id','!=',$caja->id)
        ->get();

        return count($resultado) > 0 ? false : true;
    }

}
