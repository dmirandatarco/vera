<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'almacen_id',
        'producto_id',
        'cantidad',
        'ubicacion',
    ];

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

}
