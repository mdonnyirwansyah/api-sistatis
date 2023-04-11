<?php

namespace App\Http\Resources\Thesis;

use App\Http\Resources\FieldResource;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\SeminarsResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ThesisResource extends JsonResource
{
    public function toArray($request)
    {
        $start = Carbon::parse($this->register_date);
        $finish = Carbon::parse($this->finish_date) ?? Carbon::now();
        $duration = $start->floatDiffInMonths($finish);

        return [
            'id' => $this->id,
            'register_date' => $this->register_date,
            'title' => $this->title,
            'field' => new FieldResource($this->whenLoaded('field')),
            'supervisors' => LecturerResource::collection($this->whenLoaded('lecturers')),
            'status' => $this->status,
            'finish_date' => $this->finish_date,
            'thesis_duration' => round($duration, 2),
            'seminars' => SeminarResource::collection($this->whenLoaded('seminars')),
        ];
    }
}
