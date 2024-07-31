<?php

namespace App\Http\Requests\Auth;

use Knuckles\Scribe\Attributes\BodyParam;
use Illuminate\Foundation\Http\FormRequest;

#[BodyParam('name', 'string', "User's name", required: true, example: 'John Doe')]
#[BodyParam('email', 'string', "User's email address", required: true, example: 'john@doe.com')]
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:256'],
            'email' => ['required', 'email', 'min:8', 'max:256', 'unique:users'],
        ];
    }
}
