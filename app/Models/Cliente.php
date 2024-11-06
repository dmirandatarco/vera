<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'documento',
        'num_documento',
        'sunat',
        'razon_social',
        'nombre_comercial',
        'telefono',
        'direccion',
        'correo',
        'zona',
        'tipo',
        'estado',
    ];
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class);
    }
}
