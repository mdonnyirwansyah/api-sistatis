<?php

namespace App\Http\Resources\Thesis;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChiefOfExaminerResource;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\LocationResource;

class SeminarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'register_date' => $this->register_date,
            'status' => $this->status,
            'type' => $this->type,
            'date' => $this->date,
            'time' => $this->time,
            'location' => new LocationResource($this->whenLoaded('location')),
            'chief_of_examiner' => new ChiefOfExaminerResource($this->whenLoaded('chiefOfExaminer')),
            'examiners' => LecturerResource::collection($this->whenLoaded('lecturers')),
            'semester' => $this->semester
        ];
    }
}
