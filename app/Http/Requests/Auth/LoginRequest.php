<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Always returns true as this request is publicly accessible.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> Validation rules for login request.
     */
    public function rules(): array
    {
        return [
            // Validate the email field: required, string, and must be a valid email address
            'email' => ['required', 'string', 'email'],

            // Validate the password field: required, string
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException If authentication fails.
     */
    public function authenticate(): void
    {
        // Ensure the request is not rate-limited (too many attempts)
        $this->ensureIsNotRateLimited();

        // Attempt to authenticate the user with the provided email and password
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Increment the rate limiter if authentication fails
            RateLimiter::hit($this->throttleKey());

            // Throw validation exception with a custom error message for failed authentication
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'), // Custom failure message for email
            ]);
        }

        // Clear the rate limiter if authentication is successful
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate-limited.
     *
     * @throws \Illuminate\Validation\ValidationException If too many attempts are made.
     */
    public function ensureIsNotRateLimited(): void
    {
        // Check if the user has exceeded the rate limit (5 attempts)
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return; // Allow the request if the limit hasn't been exceeded
        }

        // Trigger the Lockout event
        event(new Lockout($this));

        // Get the time remaining until the rate limit is reset
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Throw a validation exception with a custom message including the remaining wait time
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds, // Remaining seconds until the limit resets
                'minutes' => ceil($seconds / 60), // Convert seconds to minutes for display
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string The throttle key used for rate limiting based on the user's email and IP address.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
