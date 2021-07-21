<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc',
            'email.required' => 'Trường email là bắt buộc',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'email.unique' => 'Địa chỉ email đã được sử dụng',
            'password.required' => 'Trường mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu bao gồm ít nhất 8 kí tự',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu'
        ];
    }
}
