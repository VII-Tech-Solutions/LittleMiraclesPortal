<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Workshop Request
 */
class WorkshopRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::TITLE => 'required|min:2|max:255',
            Attributes::PRICE => 'required',
            Attributes::IMAGE => 'required',
            Attributes::POSTED_AT => 'required',
            Attributes::CONTENT => 'required',
        ];
    }
}
