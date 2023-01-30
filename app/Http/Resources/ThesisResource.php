<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThesisResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'thesis' => [
                'register_date' => $this->register_date,
                'title' => $this->title,
                'field' => new FieldResource($this->whenLoaded('field')),
                'supervisors' => LecturerResource::collection($this->whenLoaded('lecturers'))
            ],
            'seminars' => ThesisSeminarsResource::collection($this->whenLoaded('seminars')),
        ];
    }
}
