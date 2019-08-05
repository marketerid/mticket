<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class SaveBankRequest extends FormRequest
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
            'bank'          => 'required',
            'account_no'    => 'required',
            'user_name'     => 'required',
            'password'      => 'required',
            'token'         => '',
            'cron_checker_minute'   => '',
        ];
    }
}
