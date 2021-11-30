<?php


namespace App\Http\Requests;

use App\Constants\Attributes;
use Illuminate\Foundation\Http\FormRequest;

class SessionPackageRequest extends FormRequest
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
            Attributes::IMAGE =>'required',
            Attributes::TITLE =>'required',
            Attributes::TAG =>'required',
            Attributes::PRICE =>'required',
            Attributes::CONTENT =>'required',
            Attributes::LOCATION_TEXT =>'required',
            Attributes::LOCATION_LINK =>'required',

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

        ];
    }
}
