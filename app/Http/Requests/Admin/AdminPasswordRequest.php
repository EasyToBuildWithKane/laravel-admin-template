<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed|different:old_password',
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Please enter your current password.',
            'new_password.required' => 'Please enter a new password.',
            'new_password.min' => 'The new password must be at least 6 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
            'new_password.different' => 'The new password must be different from the old one.',
        ];
    }
}
