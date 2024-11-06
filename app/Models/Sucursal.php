<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function almacen()
    {
        return $this->hasOne(Almacen::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
