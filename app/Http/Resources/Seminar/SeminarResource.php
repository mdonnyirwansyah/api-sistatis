<?php

namespace App\Http\Resources\Seminar;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChiefOfExaminerResource;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\LocationResource;

class SeminarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'student' => [
                'id' => $this->thesis->student->id,
                'name' => $this->thesis->student->name,
                'nim' => $this->thesis->student->nim,
                'phone' => $this->thesis->student->phone,
                'register_date' => $this->thesis->student->register_date,
                'generation' => $this->thesis->student->generation,
            ],
            'thesis' => new ThesisResource($this->whenLoaded('thesis')),
            'seminar' => [
                'id' => $this->id,
                'register_date' => $this->register_date,
                'status' => $this->status,
                'type' => $this->type,
                'date' => $this->date,
                'time' => $this->time,
                'location' => new LocationResource($this->whenLoaded('location')),
                'chief_of_examiner' => new ChiefOfExaminerResource($this->whenLoaded('chiefOfExaminer')),
                'examiners' => LecturerResource::collection($this->whenLoaded('lecturers')),
                'semester' => $this->semester,
                'number_of_letter' => $this->number_of_letter,
                'validate_date' => $this->validate_date
            ]
        ];
    }
}
