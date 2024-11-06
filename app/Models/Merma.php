<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merma extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'user_id',
        'trabajo_id',
        'producto_id',
        'cliente_id',
        'descripcion',
        'cantidad',
        'sucursal_id',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class);
    }
}
