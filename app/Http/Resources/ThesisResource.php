<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ThesisResource extends JsonResource
{
    public function toArray($request)
    {
        $start = Carbon::parse($this->register_date);
        $finish = Carbon::parse($this->finish_date) ?? Carbon::now();
        $duration = $start->floatDiffInMonths($finish);

        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'thesis' => [
                'register_date' => $this->register_date,
                'title' => $this->title,
                'field' => new FieldResource($this->whenLoaded('field')),
                'supervisors' => LecturerResource::collection($this->whenLoaded('lecturers')),
                'status' => $this->status,
                'finish_date' => $this->finish_date,
                'duration' => round($duration, 2)
            ],
            'seminars' => ThesisSeminarsResource::collection($this->whenLoaded('seminars')),
        ];
    }
}
