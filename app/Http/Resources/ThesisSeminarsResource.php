<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThesisSeminarsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'register_date' => $this->register_date,
            'status' => $this->status,
            'name' => $this->name,
            'date' => $this->date,
            'time' => $this->time,
            'location' => new LocationResource($this->whenLoaded('location')),
            'examiners' => LecturerResource::collection($this->whenLoaded('lecturers')),
            'semester' => $this->semester
        ];
    }
}
