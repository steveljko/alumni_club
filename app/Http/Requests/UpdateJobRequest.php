<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Knuckles\Scribe\Attributes\BodyParam;
use Illuminate\Validation\Validator;
use Illuminate\Support\Carbon;

#[BodyParam("company_name", "string", "Company name", required: true, example: "Moto IT")]
#[BodyParam("position", "string", required: true, example: "Front-end Develper")]
#[BodyParam("start_date", "string", "Must be a valid date in the format Y-m-d", required: true, example: "2020-04-14")]
#[BodyParam("end_date", "string", "Must be a valid date in the format Y-m-d, and after start_date", required: false, example: "2022-4-14")]
#[BodyParam("desc", "string", "Describe everything about this job...", example: "")]
class UpdateJobRequest extends FormRequest
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
      'company_name' => [
        'required',
        'string',
        'max:255',
      ],
      'position' => [
        'required',
        'string',
        'max:255',
      ],
      'start_date' => [
        'required',
        'date',
      ],
      'end_date' => [
        'nullable',
        'date',
        'after_or_equal:start_date',
      ],
      'desc' => [
        'nullable',
        'string',
      ],
    ];
  }

  /**
   * Configure custom validation rules.
   *
   * @param \Illuminate\Validation\Validator $validator
   * @return void
   */
  public function withValidator(Validator $validator): void
  {
    $validator->after(function (Validator $validator) {
      $startDate = $this->start_date;
      $endDate = $this->end_date;

      if ($startDate && $endDate) {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if ($start->gte($end)) {
          $validator
            ->errors()
            ->add('end_date', 'The end date must be a date after the start date.');
        }
      }
    });
  }
}
