<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Notification Request
 */
class NotificationRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             Attributes::TITLE => 'required',
             Attributes::MESSAGE => 'required',
        ];
    }
}
