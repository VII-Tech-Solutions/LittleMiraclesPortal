<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Promotion Request
 */
class PromotionRequest extends CustomRequest
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
            Attributes::OFFER => 'required',
            Attributes::IMAGE => 'required',
            Attributes::TYPE => 'required',
            Attributes::PROMO_CODE => 'required',
            Attributes::POSTED_AT => 'required',
            Attributes::VALID_UNTIL => 'required',
            Attributes::CONTENT => 'required',
        ];
    }
}
