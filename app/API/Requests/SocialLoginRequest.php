<?php

namespace App\API\Requests;

use App\Constants\Attributes;

/**
 * Class SocialLoginRequest
 * @package App\API\Requests
 */
class SocialLoginRequest extends CustomRequest
{
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
}
