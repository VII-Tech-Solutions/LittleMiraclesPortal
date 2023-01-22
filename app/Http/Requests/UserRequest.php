<?php


namespace App\Http\Requests;

use App\Constants\Attributes;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Attributes::FIRST_NAME => 'required|min:3|max:20',
            Attributes::LAST_NAME => 'required|min:3|max:20',
            Attributes::GENDER=>'required',
            Attributes::BIRTH_DATE=>'required',
            Attributes::COUNTRY_CODE=>'required',
            Attributes::PHONE_NUMBER=>'required',
            Attributes::PAST_EXPERIENCE=>'required',
            Attributes::PROVIDER=>'required',
            Attributes::AVATAR => 'required',
            Attributes::PRO_PAST_EXPERIENCE => 'required',
            Attributes::HAPPY_PAST_EXPERIENCE => 'required',


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
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "image.base64image" => "Image size cannot exceed 1MB.",
            "image.base64image_ratio" => "Image ratio should be 1:2",
        ];
    }
}
