<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        $start = Carbon::parse($this->register_date);
        $finish = Carbon::parse($this->graduate_date) ?? Carbon::now();
        $duration = $start->floatDiffInYears($finish);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'nim' => $this->nim,
            'phone' => $this->phone,
            'register_date' => $this->register_date,
            'generation' => $this->generation,
            'status' => $this->status,
            'gpa' => number_format($this->gpa, 2, '.', ','),
            'graduate_date' => $this->graduate_date,
            'study_duration' => round($duration, 2),
            'thesis' => new ThesisResource($this->whenLoaded('thesis'))
        ];
    }
}
