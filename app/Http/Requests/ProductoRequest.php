<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            $tipo='nullable|max:100|unique:productos,codigo,'.$this->id;
        }else{
            $tipo='nullable|max:100|unique:productos';
        }
        return [
            'nombre' => 'required|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
            'codigo' => $tipo,
            'precio' => 'required|numeric|min:0',
            'precio_doc' => 'required|numeric|min:0',
        ];
    }
}
