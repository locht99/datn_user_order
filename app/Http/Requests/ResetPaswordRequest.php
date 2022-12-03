<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function PHPSTORM_META\map;

class ResetPaswordRequest extends FormRequest
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
            "password" => "required|min:6",
            "password_confirmation" => "required|same:password"
        ];
    }

    public function messages()
    {
        return [
            "password.required" => "Mật khẩu không được để trống",
            "password.min" => "Mật khẩu phải lớn hơn 6 kí tự",
            "password_confirmation.required" => "Bạn chưa nhập lại mật khẩu",
            "password_confirmation.same" => "Nhập lại mật khẩu không khớp",
        ];
    }
}
