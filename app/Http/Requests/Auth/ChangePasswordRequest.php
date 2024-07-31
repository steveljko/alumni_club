<?php

namespace App\Http\Requests\Auth;

use Knuckles\Scribe\Attributes\BodyParam;
use Illuminate\Foundation\Http\FormRequest;

#[BodyParam('password', 'string', 'New password', required: true, example: 'password')]
#[BodyParam('password_confirmation', 'string', 'New password confirmed', required: true, example: 'password')]
class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8', 'max:256', 'confirmed'],
        ];
    }
}
