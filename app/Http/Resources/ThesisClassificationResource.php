<?php

namespace App\Http\Resources;

use App\Http\Resources\Thesis\ThesisResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ThesisClassificationResource extends JsonResource
{
    public function toArray($request)
    {
        $start = Carbon::parse($this->register_date);
        $finish = Carbon::parse($this->graduate_date) ?? Carbon::now();
        $duration = $start->floatDiffInYears($finish);

        return [
            'generation' => $this->generation,
            'gpa' => number_format($this->gpa, 2, '.', ','),
            'study_duration' => round($duration, 2),
            'thesis' => new ThesisResource($this->whenLoaded('thesis'))
        ];
    }
}
