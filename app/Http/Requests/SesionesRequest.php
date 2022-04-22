<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SesionesRequest extends FormRequest
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
            'id_group'     => 'required',
            'id_course'    => 'required',
            'date_session' => 'required',
        ];
    }
}
