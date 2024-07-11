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
            'date_of_birth' => ['required'],
            'gender' => ['required'],
            'email' => ['required'],
            'email_visible' => ['boolean'],
            'phone_number' => ['required'],
            'phone_number_visible' => ['boolean'],
            'uni_start_year' => ['boolean'],
            'uni_finish_year' => ['boolean'],
            'bio' => ['string', 'min:8', 'max:512'],
        ];
    }
}
