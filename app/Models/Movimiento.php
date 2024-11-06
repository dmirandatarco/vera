<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Movimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'sucursal_id',
        'almacen_id',
        'tipo_id',
        'user_id',
        'proveedor_id',
        'movimiento_id',
        'tipo_doc',
        'nume_doc',
        'fecha',
        'estado',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function tipo(){
        return $this->belongsTo(Tipo::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function almacendestino(){
        return $this->belongsTo(Almacen::class,'almacen_2');
    }

    public function detalles(){
        return $this->hasMany(detalleMovimiento::class);
    }
    public function movimientos(){
        return $this->hasOne(Movimiento::class);
    }
}




