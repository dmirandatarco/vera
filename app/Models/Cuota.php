<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'numero',
        'fecha',
        'pagado',
    ];
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
