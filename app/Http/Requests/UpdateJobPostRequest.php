<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPostRequest extends FormRequest
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
            'position' => ['required', 'string', 'min:6', 'max:128'],
            'description' => ['string', 'min:10', 'max:256'],
            'company_name' => ['required', 'string', 'min:6', 'max:128'],
            'company_city' => ['required', 'string', 'min:6', 'max:128'],
            'opening_start' => ['required', 'date'],
            'opening_end' => ['required', 'date', 'after:start_time'],
            'job_page_url' => ['url:https', 'min:6', 'max:64'],
        ];
    }
}
