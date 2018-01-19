<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DevelopmentsCreateRequest extends Request
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
            'development_name'        => 'required',
            'development_location'    => 'required',
            'development_num_plots'   => 'required',
            'development_description' => 'required',
//            'photo_id' => 'required'
        ];
    }
}
