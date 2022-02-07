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
            Attributes::AVAILABLE_FROM => 'required',
            Attributes::VALID_UNTIL => 'required',
            Attributes::CONTENT => 'required',
        ];
    }


    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            Attributes::AVAILABLE_FROM => Attributes::START_DATE,
            Attributes::VALID_UNTIL => Attributes::END_DATE,
        ];
    }
}
