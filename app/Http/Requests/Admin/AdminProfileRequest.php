<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ensures only authenticated users can update their profile
        return Auth::check();
    }

    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name'        => [
                'required',
                'string',
                'min:4',
                'max:50',
                // Prevents using special characters and email-like format
                'not_regex:/[@#$%]|^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                Rule::unique('users', 'name')->ignore($userId),
            ],
            'first_name'  => ['nullable', 'string', 'max:30'],
            'last_name'   => ['nullable', 'string', 'max:30'],
            'phone'       => ['nullable', 'regex:/^(0|\+84)[0-9]{9}$/'],
            'link_social' => ['nullable', 'string', 'max:255', 'url'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Please enter a name.',
            'name.min'           => 'The name must be at least 4 characters.',
            'name.max'           => 'The name may not exceed 50 characters.',
            'name.unique'        => 'This username is already taken.',
            'name.not_regex'     => 'The name must not contain special characters.',
            'first_name.max'     => 'First name may not exceed 30 characters.',
            'last_name.max'      => 'Last name may not exceed 30 characters.',
            'phone.regex'        => 'Invalid Vietnamese phone number format.',
            'link_social.url'    => 'The social link must be a valid URL.',
            'link_social.max'    => 'The social link may not exceed 255 characters.',
            'photo.image'        => 'The profile picture must be an image.',
            'photo.mimes'        => 'Only jpg, jpeg, and png formats are allowed.',
            'photo.max'          => 'The image size may not exceed 2MB.',
        ];
    }
}
