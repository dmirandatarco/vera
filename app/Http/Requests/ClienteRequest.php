<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->id){
            $tipo='nullable|max:150|unique:clientes,num_documento,'.$this->id;
        }else{
            $tipo='nullable|max:150|unique:clientes';
        }
        return [
            'documento'     =>  'nullable|max:50',
            'num_documento' =>  $tipo,
            'razon_social'        =>  'nullable|max:150',
            'nombre_comercial'       =>  'nullable|max:50',
            'telefono'     =>  'nullable|max:150',
            'direccion'        =>  'nullable|max:250',
            'correo'    =>  'nullable|max:150',
            'zona'    =>  'nullable|max:240',
        ];
    }
}
