<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam("date_of_birth", "string", "Must be a valid date in the format d-m-Y", required: true, example: "10-04-1997")]
#[BodyParam("gender", "string", "Must be either 'male' or 'female'", required: true, example: "male")]
#[BodyParam("email_visible", "boolean", required: true, example: false)]
#[BodyParam("phone_number", "string", "Must be a phone number that starts with +381", required: true, example: "+3816060606")]
#[BodyParam("phone_number_visible", "boolean", required: true, example: false)]
#[BodyParam("uni_start_year", "integer", required: true, example: 2020)]
#[BodyParam("uni_finish_year", "integer", required: true, example: 2023)]
#[BodyParam("bio", "string", "User's biography", required: false, example: "")]
class ChangeUserDetailsRequest extends FormRequest
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
      'date_of_birth' => ['required', 'date_format:d-m-Y'],
      'gender' => ['required', 'in:male,female'],
      'email_visible' => ['required', 'boolean'],
      'phone_number' => ['required', 'regex:/^\+381[0-9]{8,9}$/'],
      'phone_number_visible' => ['required', 'boolean'],
      'uni_start_year' => ['required', 'digits:4', 'integer'],
      'uni_finish_year' => ['required', 'digits:4', 'integer'],
      'bio' => ['nullable', 'string', 'min:8', 'max:512'],
    ];
  }
}
