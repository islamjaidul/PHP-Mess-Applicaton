<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomerRequest extends Request
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
            'firstname'      => 'required|max: 20',
            'lastname'       => 'required|max: 20',
            'email'         => 'required|email|max:50|unique:customer,email',
            'password'      => 'required|min:8|confirmed',
            'companyname'   => 'required|max: 20',
            'address'       => 'required',
            'postal_code'    => 'required',
            'city'          => 'required',
            'phone'         => 'required'
        ];
    }
}
