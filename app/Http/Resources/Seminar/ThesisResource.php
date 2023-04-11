<?php

namespace App\Http\Resources\Seminar;

use App\Http\Resources\FieldResource;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\SeminarsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ThesisResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'register_date' => $this->register_date,
            'title' => $this->title,
            'field' => new FieldResource($this->whenLoaded('field')),
            'supervisors' => LecturerResource::collection($this->whenLoaded('lecturers')),
            'status' => $this->status,
        ];
    }
}
