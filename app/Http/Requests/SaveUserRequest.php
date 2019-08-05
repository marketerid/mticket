<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SaveUserRequest extends FormRequest
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
            'email'         => 'required|email|unique:users,email,' . $this->getSegmentFromEnd(),
            'name'          => 'required',
            'phone'         => 'required|phone'
        ];
    }



    private function getSegmentFromEnd() {
        $user   = Auth::guard('web')->user();

        return $user->id;
    }
}
