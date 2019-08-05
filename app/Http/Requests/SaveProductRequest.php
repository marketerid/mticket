<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class SaveProductRequest extends FormRequest
{
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
            'site_id'           => 'required',
            'title'             => 'required',
            'description'       => 'required',
            'price_original'    => 'required',
            'price_discount'    => ''
        ];
    }
}
