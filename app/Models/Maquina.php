<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'sucursal_id',
    ];
    
    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
