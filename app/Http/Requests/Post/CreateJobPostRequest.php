<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateJobPostRequest extends BaseFormRequest
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
            'company_website_url' => ['string', 'url:https', 'string', 'min:6', 'max:64'],
            'company_address' => ['required', 'string', 'min:6', 'max:128'],
            'company_city' => ['required', 'string', 'min:6', 'max:128'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'job_page_url' => ['string', 'url:https', 'min:6', 'max:64'],
        ];
    }

    /**
     * Handle failed validation and return validation errors as a JSON response.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
