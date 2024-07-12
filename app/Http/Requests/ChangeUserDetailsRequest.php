<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'gender' => ['required'],
            'email_visible' => ['required', 'boolean'],
            'phone_number' => ['required', 'regex:/^\+381[0-9]{8,9}$/'],
            'phone_number_visible' => ['required', 'boolean'],
            'uni_start_year' => ['required', 'digits:4', 'integer'],
            'uni_finish_year' => ['required', 'digits:4', 'integer'],
            'bio' => ['nullable', 'string', 'min:8', 'max:512'],
        ];
    }
}
