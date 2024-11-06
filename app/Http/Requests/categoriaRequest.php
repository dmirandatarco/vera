<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categoriaRequest extends FormRequest
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
            $tipo='required|max:50|unique:categorias,nombre,'.$this->id;
            $abrevitaura='required|max:10|unique:categorias,abreviatura,'.$this->id;
        }else{
            $tipo='required|max:50|unique:categorias';
            $abrevitaura='required|max:10|unique:categorias';
        }
        return [
            'nombre' => $tipo,
            'abreviatura' => $abrevitaura,
            'categoria_id' => 'nullable|exists:categorias,id',
        ];
    }
}
