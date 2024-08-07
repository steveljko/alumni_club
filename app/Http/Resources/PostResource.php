<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
        ];

        if ($this->type->value == 'default') {
            $data['data'] = new PostDefaultResource($this->default);
        }

        if ($this->type->value == 'event') {
            $data['data'] = new PostEventResource($this->event);
        }

        return $data;
    }
}
