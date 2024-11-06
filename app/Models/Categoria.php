<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'abreviatura',
        'categoria_id',
        'orden'
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    protected function abreviatura(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function categoriapadre(){
        return $this->belongsTo(Categoria::class,'categoria_id','id')->where('estado',1);
    }

    public function categoriashijos(){
        return $this->hasMany(Categoria::class,'categoria_id','id')->where('estado',1);
    }
}
