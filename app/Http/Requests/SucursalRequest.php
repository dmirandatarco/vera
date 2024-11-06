<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SucursalRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        if($this->id){
            $tipo='required|max:50|unique:sucursals,nombre,'.$this->id;
        }else{
            $tipo='required|max:50|unique:sucursals';
        }
        return [
            'nombre' => $tipo,
        ];
    }
}
