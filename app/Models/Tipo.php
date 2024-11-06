<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'proveedor',
        'almacen',
        'documento',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }
}
