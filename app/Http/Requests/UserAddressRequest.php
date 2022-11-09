<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "selectedProvince" => "required",
            "selectedDistrict" => "required",
            "selectedWard" => "required",
        ];
    }

    public function messages()
    {
        return [
            "selectedProvince.required" => "Tỉnh, thành phố không được để trống",
            "selectedDistrict.required" => "Quận,huyện không được để trống",
            "selectedWard.required" => "Phường, xã không được để trống"
        ];
    }
}
