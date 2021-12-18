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
            'nombres'                       => 'required',
            'apellidos'                     => 'required|min:4|max:60',
            'tipo_documento'                => 'required',
            'numero_documento'              => 'required|integer', 
            'fecha_nacimiento'              => 'required',
            'departamento_nacimiento'       => 'required',
            'ciudad_nacimiento'             => 'required',
            'sexo'                          => 'required',
            'genero'                        => 'required',
            'departamento_residencia'       => 'required',
            'ciudad_residencia'             => 'required',
            'barrio_residencia'             => 'required',
            'direccion'                     => 'required',
            'email'                         => 'required|email',
            'telefono1'                     => 'required|integer',
            'telefono2'                     => 'required|integer',
        ];
    }
}
