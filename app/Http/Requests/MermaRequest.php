<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MermaRequest extends FormRequest
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
            $tipo='required|max:50|unique:mermas,id,'.$this->id;
        }else{
            $tipo='nullable';
        }
        return [
            'id' => $tipo,
        ];
    }
}
