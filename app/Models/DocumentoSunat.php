<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoSunat extends Model
{
    use HasFactory;

    protected $fillable = [
        'xml',
        'hash',
        'respuesta',
        'codeError',
        'messageError',
        'cdrZip',
        'codeCdr',
        'descripcionCdr',
        'notesCdr',
        'venta_id',
    ];
}