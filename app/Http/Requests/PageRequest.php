<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Page Request
 */
class PageRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::TITLE => 'required|min:1|max:255',
            Attributes::CONTENT => 'required',
        ];
    }
}
