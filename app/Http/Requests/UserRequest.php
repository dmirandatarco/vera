<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if(request()->routeIs('user.store')){
            $tipo='required|max:50|unique:users';
            $pasword = 'required|max:191';
        }else{
            $tipo='required|max:50|unique:users,usuario,'.$this->user->id;
            $pasword = 'nullable|max:191';
        }
        return [
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:150',
            'tipo_documento' => 'nullable|max:20',
            'num_documento' => 'nullable|max:20',
            'celular' => 'nullable|max:20',
            'email' => 'nullable|email|max:50',
            'usuario' => $tipo,
            'password' => $pasword,
            'imagen' => 'nullable',
            'idrol' => 'required|exists:roles,id',
            'sucursal_id' => 'required|exists:sucursals,id'
        ];
    }
}
