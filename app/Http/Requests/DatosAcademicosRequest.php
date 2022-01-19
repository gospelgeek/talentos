<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatosAcademicosRequest extends FormRequest
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
        'institution_name'     => 'required',
        'id_institution_type'  => 'required',
        'year_graduation'      => 'required',
        'bachelor_title'       => 'required',
        'icfes_date'           => 'required',
        'snp_register'         => 'required',
        'icfes_score'          => 'required',
        'graduate'             => 'required',
        'graduate_schooling'   => 'required',
        ];
    }
}
