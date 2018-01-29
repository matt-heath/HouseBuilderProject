<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlotsRequest extends Request
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
            //
            'development_id' => 'required',
            'house_type' => 'required',
            'phase' => 'required',
            'plot_name' => 'required',
            'sqft' => 'required',
            'status' => 'required'
        ];
    }
}
