<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
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
      'comapny_name' => ['required', 'string', 'min:3', 'max:16'],
      'position' => ['required', 'string', 'min:3', 'max:24'],
      'start_date' => ['required', 'date', 'before:end_date'],
      'end_date' => ['required', 'date', 'after:start_date'],
      'desc' => ['min:8', 'max:256'],
    ];
  }
}
