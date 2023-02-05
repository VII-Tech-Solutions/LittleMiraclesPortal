<?php

namespace App\API\Requests;

use App\Constants\Attributes;
use App\Constants\Values;

class PhotographerLoginRequest extends CustomRequest
{
    public function rules() {
        return [
            Attributes::EMAIL => 'string|required|max:250',
            Attributes::PASSWORD => 'string|required'
        ];
    }

    public function attributes()
    {
        return [
            Attributes::EMAIL => 'Email',
            Attributes::PASSWORD => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute is required!',
            'max' => 'The :attribute should be less than :max characters!',
        ];
    }}
