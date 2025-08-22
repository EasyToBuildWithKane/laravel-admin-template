<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }
    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name' => [
                'required',
                'string',
                'min:4',
                'max:50',
                'not_regex:/[@#$%]|^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                Rule::unique('users', 'name')->ignore($userId),
            ],
            'phone' => [
                'nullable',
                'regex:/^(0|\+84)[0-9]{9}$/'
            ],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'name.min' => 'Tên quá ngắn (ít nhất 4 ký tự).',
            'name.max' => 'Tên quá dài (tối đa 50 ký tự).',
            'name.unique' => 'Tên người dùng đã được sử dụng.',
            'name.not_regex' => 'Tên không được chứa ký tự đặc biệt.',
            'phone.regex' => 'Số điện thoại không đúng định dạng Việt Nam.',
            'photo.image' => 'Ảnh đại diện phải là hình ảnh.',
            'photo.mimes' => 'Ảnh chỉ cho phép jpg, jpeg, png.',
            'photo.max' => 'Kích thước ảnh tối đa 2MB.',
        ];
    }
}
