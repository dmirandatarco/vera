<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
        if(request()->routeIs('proveedor.update')){

            $tipo='nullable|max:50|unique:proveedors,num_documento,'.$this->proveedor->id;

        }else{
            $tipo='nullable|max:100|unique:proveedors';

        }
        return [

            'documento'     =>  'nullable|max:50',
            'num_documento' =>  $tipo,
            'nombre'        =>  'nullable|max:150',
            'celular'       =>  'nullable|max:50',
            'direccion'     =>  'nullable|max:150',
            'correo'        =>  'nullable|max:250',
            'nrocuenta1'    =>  'nullable|max:150',
            'nrocuenta2'    =>  'nullable|max:150',
        ];
    }
}
