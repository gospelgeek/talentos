<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class perfilEstudianteRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'                       => 'required',
            'lastname'                   => 'required|min:4|max:60',
            'id_document_type'           => 'required',
            'document_number'            => 'required|integer', 
            'birth_date'                 => 'required',
            'id_birth_city'              => 'required',  
            'sex'                        => 'required',
            'direction'                  => 'required',
            'email'                      => 'required|email',
            'cellphone'                  => 'required|integer',
            'phone'                      => 'required|integer',
        ];
    }
}
