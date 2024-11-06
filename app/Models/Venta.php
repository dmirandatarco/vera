<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_id',
        'almacen_id',
        'user_id',
        'cliente_id',
        'documento_id',
        'nume_doc',
        'fecha',
        'acuenta',
        'saldo',
        'total',
        'tipo',
        'pago',
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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }

    public function pagosVenta()
    {
        return $this->hasMany(Pago::class);
    }

    public function cobrosVenta()
    {
        return $this->hasMany(Cobrar::class);
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
    
    public function trabajos()
    {
        return $this->belongsToMany(Trabajo::class);
    }

    public function verCobro()
    {
        $caja = CajaCobrar::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();
        $resultado = $this->cobrosVenta()
        ->where('estado', 1)
        ->where('caja_cobrar_id',$caja->id)
        ->first();

        return $resultado ? 1:0;
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class,'venta_venta','ventas_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class,'factura_id');
    }

    public function verPago()
    {
        $caja = Caja::where('estado',1)->where('sucursal_id',\Auth::user()->sucursal_id)->first();

        $resultado = $this->pagosVenta()
        ->where('estado', 1)
        ->where('caja_id','!=',$caja->id)
        ->get();

        return count($resultado) > 0 ? false : true;
    }

    public function documentosunat()
    {
        return $this->hasOne(DocumentoSunat::class);
    }

}
