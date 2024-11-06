<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CierreRequest extends FormRequest
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
            'totalCierre' => 'required|numeric',
            'totalGlobal' => 'required|numeric',
            'observacion' => 'nullable|max:250',
        ];
    }
}
