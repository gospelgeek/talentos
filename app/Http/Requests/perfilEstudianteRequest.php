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
            'nombres'                       => 'nullable',
            'apellidos'                     => 'required|min:4|max:60',
            'tipo_documento'                => 'required',
            'numero_documento'              => 'required|integer', 
            'fecha_nacimiento'              => 'required',
            'departamento_nacimiento'       => 'nullable',
            'ciudad_nacimiento'             => 'nullable',
            'sexo'                          => 'required',
            'genero'                        => 'required',
            'departamento_residencia'       => 'nullable',
            'ciudad_residencia'             => 'nullable',
            'barrio_residencia'             => 'nullable',
            'direccion'                     => 'required',
            'email'                         => 'required|email',
            'telefono1'                     => 'required|integer',
            'telefono2'                     => 'required|integer',
        ];
    }
}
