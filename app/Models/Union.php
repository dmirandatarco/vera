<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'user_id',
        'caja_cobrar_id',
        'caja_id',
        'totalTransferido',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function cajacobrar()
    {
        return $this->belongsTo(CajaCobrar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}