<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Section Request
 */
class SectionRequest extends CustomRequest
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
            Attributes::TITLE => 'required|min:2|max:255',
            Attributes::CONTENT => 'required',
            Attributes::ACTION_TEXT => 'required',
            Attributes::GO_TO => 'required'
        ];
    }
}
