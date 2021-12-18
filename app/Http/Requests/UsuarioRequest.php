<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'name'                 => 'required',
            'apellidos_user'       => 'required', 
            'tipo_documento_user'  => 'required', 
            'cedula'               => 'required|integer',
            'email'                => 'required|email',
            'rol_id'               => 'required|integer', 
            'password'             => 'required',
        ];
    }
}
