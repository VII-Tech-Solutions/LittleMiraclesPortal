<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Sub Package Request
 */
class SubPackageRequest extends CustomRequest
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
            Attributes::DESCRIPTION => 'required',
        ];
    }
}
