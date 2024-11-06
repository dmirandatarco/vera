<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'documento',
        'num_documento',
        'nombre',
        'celular',
        'direccion',
        'correo',
        'nrocuenta1',
        'nrocuenta2',
    ];

    protected function empresa(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }
    protected function nombrecontacto(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }
    protected function direccion(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}

