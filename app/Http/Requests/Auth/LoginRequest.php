<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    protected int $maxAttempts = 3;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:50', 'min:4'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Vui lòng nhập thông tin tài khoản.',
            'login.max' => 'Tài khoản không được nhập quá 50 kí tự.',
            'login.min' => 'Tài khoản không được nhập dưới 4 kí tự',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = User::where('email', $this->login)
            ->orWhere('name', $this->login)
            ->orWhere('phone', $this->login)
            ->first();

        if (!$user) {
            $this->incrementRateLimit();
            $this->throwWithAttempts('Vui Lòng Kiểm Tra Thông Tin Đăng Nhập.');
        }

        if ($user->is_delete == 1 || $user->is_active !== 'active') {
            $this->incrementRateLimit();
            $this->throwWithAttempts('Tài khoản của bạn đã bị khóa hoặc không hoạt động.');
        }

        if (!Hash::check($this->password, $user->password)) {
            $this->incrementRateLimit();
            $this->throwWithAttempts('Mật khẩu không chính xác.');
        }

        Auth::login($user, $this->boolean('remember'));
        RateLimiter::clear($this->throttleKey());
    }

    protected function incrementRateLimit(): void
    {
        RateLimiter::hit($this->throttleKey());
    }

    protected function throwWithAttempts(string $message): void
    {
        $attemptsLeft = $this->maxAttempts - RateLimiter::attempts($this->throttleKey());
        $attemptsLeft = max(0, $attemptsLeft);

        if ($attemptsLeft > 0) {
            throw ValidationException::withMessages([
                'login' => "$message Bạn còn $attemptsLeft lượt thử."
            ]);
        }

        throw ValidationException::withMessages([
            'throttle' => RateLimiter::availableIn($this->throttleKey()),
        ]);
    }


    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), $this->maxAttempts)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'throttle' => $seconds
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login')) . '|' . $this->ip());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'login' => trim($this->login),
        ]);
    }
}
