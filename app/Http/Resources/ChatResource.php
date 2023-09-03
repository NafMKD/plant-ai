<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'response' => $this->response,
            'image' => asset('/uploads/images/'.$this->image),
            'created_at' => $this->created_at,
            'formatted_time_created' => $this->formatted_time_created,
            'formatted_time_updated' => $this->formatted_time_updated,
            'disease' => $this->disease_name,
            'probability' => $this->probability_percent
        ];
    }
}
