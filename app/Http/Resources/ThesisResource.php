<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ThesisResource extends JsonResource
{
    public function toArray($request)
    {
        $dt = Carbon::parse($this->register_date);
        $finish = Carbon::parse($this->finish_date) ?? Carbon::now();
        $duration = $dt->diffForHumans($finish);

        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'thesis' => [
                'register_date' => $this->register_date,
                'title' => $this->title,
                'field' => new FieldResource($this->whenLoaded('field')),
                'supervisors' => LecturerResource::collection($this->whenLoaded('lecturers')),
                'finish_date' => $this->finish_date,
                'duration' => $duration
            ],
            'seminars' => ThesisSeminarsResource::collection($this->whenLoaded('seminars')),
        ];
    }
}
