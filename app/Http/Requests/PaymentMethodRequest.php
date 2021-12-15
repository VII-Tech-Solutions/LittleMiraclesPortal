<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Payment Method Request
 */

class PaymentMethodRequest extends CustomRequest
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
        ];
    }
}
