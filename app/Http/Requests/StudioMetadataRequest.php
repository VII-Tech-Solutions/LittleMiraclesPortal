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
//            Attributes::IMAGE_UNSELECTED => 'required',
//            Attributes::IMAGE_SELECTED => 'required',
            Attributes::TITLE=>'required|min:2|max:255',
            Attributes::DESCRIPTION => 'required'
        ];
    }
}
