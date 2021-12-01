<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * FAQ Request
 */
class FaqRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::QUESTION => 'required|min:1|max:255',
            Attributes::ANSWER => 'required',
        ];
    }
}
