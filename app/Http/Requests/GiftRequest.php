<?php

namespace App\Http\Requests;

use App\Constants\Attributes;
use App\Constants\Tables;
use Illuminate\Validation\Rule;

/**
 * Gift Request
 */
class GiftRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::PACKAGE_ID => 'required',
            Attributes::IMAGE => 'required',
            Attributes::AVAILABLE_FROM => 'required',
            Attributes::AVAILABLE_UNTIL => 'required',
            Attributes::DAYS_OF_VALIDITY => 'required',
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
            Attributes::PACKAGE_ID => Attributes::PACKAGE
        ];
    }


}
