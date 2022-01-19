<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatosSocioeconomicosRequest extends FormRequest
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
        'id_ocupation'             =>   'required',
        'children_number'          =>   'required', 
        'id_civil_status'          =>   'required',
        'id_residence_time'        =>   'required',
        'id_housing_type'          =>   'required',
        'id_health_regime'         =>   'required',
        'sisben_category'          =>   'required',
        'id_benefits'              =>   'required',
        'household_people'         =>   'required',
        'economic_possition'       =>   'required',
        'dependent_people'         =>   'required',
        'internet_zon'             =>   'required',
        'internet_home'            =>   'required',
        'sex_document_identidad'   =>   'required',
        'id_social_conditions'     =>   'required',
        'id_disability'            =>   'required',
        'id_ethnicity'             =>   'required',
        ];
    }
}
