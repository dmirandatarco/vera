<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'serie_id',
        'codigo',
        'precio_doc',
        'precio',
        'precio_compra',
        'stock',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function serie(){
        return $this->belongsTo(Serie::class);
    }

    public function stocks() {
        return $this->hasMany(Stock::class);
    }
    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
