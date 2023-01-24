<?php

namespace App\Http\Requests;

use App\Constants\Attributes;

/**
 * Photographer Request
 */
class PhotographerRequest extends CustomRequest
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
            Attributes::EMAIL => 'unique:users|unique:photographers',
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
            "unique" => "This email already exists as a customer, use a different email for admin/photographers",
        ];
    }}
