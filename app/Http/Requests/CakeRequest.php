<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Cake Request
 */
class CakeRequest extends CustomRequest
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
            Attributes::CATEGORY_ID => 'required',
            Attributes::IMAGE => 'required',
        ];
    }
}
