<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Almacen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'predeterminada',
        'sucursal_id',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
