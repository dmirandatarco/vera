<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaquinaRequest extends FormRequest
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
            $tipo='required|max:150|unique:maquinas,nombre,'.$this->id;
        }else{
            $tipo='required|max:150|unique:maquinas';
        }
        return [
            'descripcion'     =>  'nullable|max:250',
            'nombre' =>  $tipo,
        ];
    }
}
