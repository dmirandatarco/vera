<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagosRequest extends FormRequest
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
        return [
            'total' => 'required|numeric',
            'documento' => 'nullable|max:250',
            'observacion' => 'nullable|max:250',
            'medio_id' => 'required|exists:medios,id',
        ];
    }
}
