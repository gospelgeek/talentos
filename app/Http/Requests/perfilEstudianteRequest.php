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
            'sex'                        => 'required',
            'email'                      => 'required|email',
            'linea'                      => 'required',
            'id_group'                   => 'required',
        ];
    }
}
