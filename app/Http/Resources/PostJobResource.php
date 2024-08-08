<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostJobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'position' => $this->position,
            'description' => $this->descripton,
            'company_name' => $this->company_name,
            'company_city' => $this->company_city,
            'opening_start' => $this->opening_start,
            'opening_end' => $this->opening_end,
            'job_page_url' => $this->job_page_url,
        ];
    }
}
