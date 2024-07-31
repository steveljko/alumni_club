<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            $this->mergeWhen($this->phone_number_visible, [
                'phone_number' => $this->phone_number,
            ]),
            'uni_start_year' => $this->uni_start_year,
            'uni_finish_year' => $this->uni_finish_year,
            'bio' => $this->bio,
        ];
    }
}
