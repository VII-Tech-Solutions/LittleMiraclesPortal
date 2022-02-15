<?php

namespace App\API\Requests;

use App\Constants\Attributes;
use App\Constants\Messages;

/**
 * Class ProfileUpdateRequest
 * @package App\API\Requests
 */
class ProfileUpdateRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::FIRST_NAME => 'string|required|max:200',
            Attributes::LAST_NAME => 'string|required|max:200',
            Attributes::COUNTRY_CODE => "string|required|max:200",
            Attributes::GENDER => "int|required|max:200",
            Attributes::PHONE_NUMBER => "string|required|max:200",
            Attributes::BIRTH_DATE => "string|required|max:200",
            Attributes::IS_PARTNER => "nullable",
        ];
    }


    public function attributes()
    {
        return [
            Attributes::NAME => 'Name',
            Attributes::EMAIL => 'Email',
            Attributes::PHONE_NUMBER => "Phone number",
            Attributes::GENDER => "Gender",
            Attributes::COUNTRY_CODE => "Country code",
            Attributes::BIRTH_DATE => "Birth date",
        ];
    }

    public function messages()
    {
        return [
            'required' => Messages::ATTRIBUTE_REQUIRED,
            'max' => Messages::MAX,
        ];
    }
}
