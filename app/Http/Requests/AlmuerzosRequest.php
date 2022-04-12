<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlmuerzosRequest extends FormRequest
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
        'date'                 => 'required',
        'number_lunches_line1' => 'required',
        'number_lunches_line2' => 'required',
        'number_lunches_line3' => 'required',
        ];
    }
}
