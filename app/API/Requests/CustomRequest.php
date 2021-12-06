<?php

namespace App\API\Requests;

use App\Constants\Attributes;
use App\Constants\Messages;

/**
 * Class CustomRequest
 * @package App\API\Requests
 */
class CustomRequest extends \VIITech\Helpers\Requests\CustomRequest
{

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
