<?php

namespace App\Models;

use App\Http\Requests\EstacionRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'num_documento',
        'celular',
        'email',
        'usuario',
        'password',
        'imagen',
        'sucursal_id',
        'maquina_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    protected function apellido(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    protected function password(): Attribute
    {
        return new Attribute(
            set: function($value){
                return bcrypt($value);
            }
        );
    }
    public function sucursal()
    {
        return $this->belongsTo('App\Models\Sucursal');
    }
    
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function estacion()
    {
        return $this->belongsTo(Maquina::class,'maquina_id');
    }
}
