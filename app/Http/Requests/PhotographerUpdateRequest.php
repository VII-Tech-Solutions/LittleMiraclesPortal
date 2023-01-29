<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

class PhotographerUpdateRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::NAME => 'required|min:1|max:255',
            Attributes::IMAGE => 'required',
            Attributes::EMAIL => 'required',
        ];
    }
}
