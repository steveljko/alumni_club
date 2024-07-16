<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam("company_name", "string", "Company name", required: true, example: "Moto IT")]
#[BodyParam("position", "string", required: true, example: "Front-end Develper")]
#[BodyParam("start_date", "string", "Must be a valid date in the format Y-m-d", required: true, example: "2020-04-14")]
#[BodyParam("end_date", "string", "Must be a valid date in the format Y-m-d, and after start_date.", required: true, example: "2022-4-14")]
#[BodyParam("desc", "string", "Describe what you do...", example: "")]
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
      'company_name' => ['required', 'string', 'min:3', 'max:16'],
      'position' => ['required', 'string', 'min:3', 'max:24'],
      'start_date' => ['required', 'date', 'before:end_date'],
      'end_date' => ['required', 'date', 'after:start_date'],
      'desc' => ['min:8', 'max:256'],
    ];
  }
}
