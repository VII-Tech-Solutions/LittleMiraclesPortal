<?php

namespace App\API\Requests;

use App\Constants\Attributes;
use App\Constants\Messages;

/**
 * Class SocialLoginRequest
 * @package App\API\Requests
 */
class SocialLoginRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::EMAIL => 'string|nullable|max:250',
            Attributes::NAME => 'nullable',
            Attributes::ID => 'string|max:250',
            Attributes::PHOTO_URL => 'nullable',
            Attributes::PROVIDER => 'string|max:250',
            Attributes::USERNAME => 'string|nullable|max:250',
        ];
    }


    public function attributes()
    {
        return [
            Attributes::EMAIL => 'Email',
            Attributes::NAME => 'Name',
            Attributes::ID => 'ID',
            Attributes::PHOTO_URL => 'Photo',
            Attributes::PROVIDER => 'Provider',
            Attributes::USERNAME => 'Username',
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
