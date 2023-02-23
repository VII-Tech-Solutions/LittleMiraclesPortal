<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Studio Metadata Request
 */
class StudioMetadataRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            Attributes::IMAGE => 'required',
            Attributes::TITLE=>'required',
            Attributes::DESCRIPTION => 'required'
        ];
    }
}
