<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'event_page_url' => $this->event_page_url,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'address' => $this->address,
            'city' => $this->city,
            'thumb_url' => $this->thumb_url,
        ];
    }
}
