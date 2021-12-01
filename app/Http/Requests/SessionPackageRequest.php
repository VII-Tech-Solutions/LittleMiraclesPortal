<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Session Package Request
 */
class SessionPackageRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::IMAGE => 'required',
            Attributes::TITLE => 'required',
            Attributes::TAG => 'required',
            Attributes::PRICE => 'required',
            Attributes::CONTENT => 'required',
            Attributes::LOCATION_TEXT => 'required',
            Attributes::LOCATION_LINK => 'required',
        ];
    }
}
