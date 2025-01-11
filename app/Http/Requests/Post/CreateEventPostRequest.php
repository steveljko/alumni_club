<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateEventPostRequest extends BaseFormRequest
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
            'title' => ['required', 'string', 'min:6', 'max:128'],
            'description' => ['string', 'min:10', 'max:256'],
            'event_page_url' => ['url:https', 'min:6', 'max:64'],
            'start_time' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            'end_time' => ['required', 'date', 'date_format:Y-m-d H:i:s', 'after:start_time'],
            'address' => ['required', 'min:6', 'max:64'],
            'city' => ['required', 'min:6', 'max:64'],
            // 'thumbnail_image' => ['nullable', 'file', 'mimes:jpeg,jpg', 'max:2048'],
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
