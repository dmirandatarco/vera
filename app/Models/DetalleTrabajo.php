<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTrabajo extends Model
{
    use HasFactory;

    protected $fillable = [
        'trabajo_id',
        'producto_id',
        'cantidad',
        'precio',
        'eje',
        'dip',
        'add',
    ];

    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
