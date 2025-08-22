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
            'name'       => [
                'required',
                'string',
                'min:4',
                'max:50',
                'not_regex:/[@#$%]|^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                Rule::unique('users', 'name')->ignore($userId),
            ],
            'first_name' => ['nullable', 'string', 'max:30'],
            'last_name'  => ['nullable', 'string', 'max:30'],
            'phone'      => ['nullable', 'regex:/^(0|\+84)[0-9]{9}$/'],
            'link_social'=> ['nullable', 'string', 'max:255', 'url'],
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Vui lòng nhập tên.',
            'name.min'          => 'Tên quá ngắn (ít nhất 4 ký tự).',
            'name.max'          => 'Tên quá dài (tối đa 50 ký tự).',
            'name.unique'       => 'Tên người dùng đã được sử dụng.',
            'name.not_regex'    => 'Tên không được chứa ký tự đặc biệt.',
            'first_name.max'    => 'Tên đệm quá dài (tối đa 30 ký tự).',
            'last_name.max'     => 'Họ quá dài (tối đa 30 ký tự).',
            'phone.regex'       => 'Số điện thoại không đúng định dạng Việt Nam.',
            'link_social.url'   => 'Link social không hợp lệ.',
            'link_social.max'   => 'Link social quá dài (tối đa 255 ký tự).',
            'photo.image'       => 'Ảnh đại diện phải là hình ảnh.',
            'photo.mimes'       => 'Ảnh chỉ cho phép jpg, jpeg, png.',
            'photo.max'         => 'Kích thước ảnh tối đa 2MB.',
        ];
    }
}
