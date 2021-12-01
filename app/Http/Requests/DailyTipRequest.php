<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Daily Tip Request
 */
class DailyTipRequest extends CustomRequest
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
            Attributes::POSTED_AT => 'required',
            Attributes::CONTENT => 'required',
        ];
    }
}
