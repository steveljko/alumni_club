<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam("email", "string", "User's email address", required: true, example: "john@doe.com")]
#[BodyParam("password", "string", "User's password", required: true, example: "password")]
class LoginRequest extends FormRequest
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
      'email' => ['required', 'email', 'min:8', 'max:256'],
      'password' => ['required', 'string', 'min:6', 'max:256'],
    ];
  }
}
