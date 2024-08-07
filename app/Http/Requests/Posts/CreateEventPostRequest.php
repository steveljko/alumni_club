<?php

namespace App\Http\Requests\Posts;

use App\Enums\PostType;
use App\Enums\PostStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventPostRequest extends FormRequest
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
            'status' => ['sometimes', 'string', Rule::enum(PostStatus::class)],
            'type' => ['required', 'string', Rule::enum(PostType::class)],
            'title' => ['required', 'string', 'min:6', 'max:128'],
            'description' => ['string', 'min:10', 'max:256'],
            'event_page_url' => ['url:https', 'min:6', 'max:64'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'address' => ['required', 'min:6', 'max:64'],
            'city' => ['required', 'min:6', 'max:64'],
        ];
    }
}
