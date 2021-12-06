<?php

namespace App\API\Requests;

use App\Constants\Attributes;
use App\Constants\Messages;

/**
 * Class RegistrationRequest
 * @package App\API\Requests
 */
class RegistrationRequest extends CustomRequest
{

    public function rules()
    {
        return [
            Attributes::EMAIL => 'string|nullable|max:250',
        ];
    }
}
