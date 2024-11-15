<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> Validation rules for the profile update request.
     */
    public function rules(): array
    {
        return [
            // Validate first name: required, string, and max 255 characters
            'first_name' => ['required', 'string', 'max:255'],

            // Validate last name: required, string, and max 255 characters
            'last_name' => ['required', 'string', 'max:255'],

            // Validate email: required, string, lowercase, valid email format, max 255 characters
            // Ensure email is unique, but ignore the current user's email for updating
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
