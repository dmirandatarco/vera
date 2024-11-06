<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalleMovimiento extends Model
{
    use HasFactory;

    protected $table = 'detalle_movimiento';

    protected $fillable = [
        'movimiento_id',
        'producto_id',
        'cantidad',
        'precio',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}





