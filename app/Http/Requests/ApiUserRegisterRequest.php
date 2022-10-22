<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiUserRegisterRequest extends FormRequest
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
            "username" => "required|min:6|unique:users,username",
            "email" => "required|email|unique:users,email",
            "address" => "required",
            "phone" => ["required", "regex:/(84|0[3|5|7|8|9])+([0-9]{8})\b/"],
            "password" => "required_with:confirm_password|min:6",
            "confirm_password" => "required|same:password"
        ];
    }

    public function messages()
    {
        return [
            "username.required" => "Tên đăng nhập không được để trống",
            "username.min" => "Tên đăng nhập phải lớn hơn 6 kí tự",
            "username.unique" => "Tên đăng nhập đã tồn tại",
            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "email.unique" => "Email đã tồn tại",
            "address.required" => "Địa chỉ không được để trống",
            "phone.required" => "Số điện thoại không được để trống",
            "phone.regex" => "Số điện thoại không đúng định dạng",
            "password.required" => "Mật khẩu không được để trống",
            "password.required_with" => "Nhập lại mật khẩu không chính xác",
            "confirm_password.required" => "Bạn phải điền xác nhận mật khẩu",
            "confirm_password.same" => "Nhập lại mật khẩu không khớp",
            "password.min" => "Mật khẩu phải lớn hơn 6 kí tự",
        ];
    }
}
