<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StudentThesisResource extends JsonResource
{
    public function toArray($request)
    {
        $start = Carbon::parse($this->register_date);
        $finish = Carbon::parse($this->finish_date) ?? Carbon::now();
        $duration = $start->floatDiffInMonths($finish);

        return [
            'duration' => round($duration, 2)
        ];
    }
}
