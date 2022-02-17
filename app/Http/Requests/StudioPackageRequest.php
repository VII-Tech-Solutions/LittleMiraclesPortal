<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Session Package Request
 */
class StudioPackageRequest extends CustomRequest
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
            Attributes::IMAGE => 'required',
            Attributes::STARTING_PRICE => 'required',
            Attributes::TYPE => 'required',
        ];
    }
}
