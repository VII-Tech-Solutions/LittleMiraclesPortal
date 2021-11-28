<?php


namespace App\Http\Requests;

use App\Constants\Attributes;
use Illuminate\Foundation\Http\FormRequest;

class PhotographersRequest
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
            'name' => 'required|min:3|max:255',
            

            //Attributes::IMAGE => 'required|base64image:1024',
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
