<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerClassificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nip' => $this->nip,
            'major' => $this->major,
            'fields' => FieldResource::collection($this->whenLoaded('fields')),
            'supervisors1_count' => $this->supervisors1_count,
            'supervisors2_count' => $this->supervisors2_count,
            'examiners_count' => $this->examiners_count,
            'chief_of_examiners_count' => $this->chief_of_examiners_count,
            'supervisors_1_by_semester_count' => $this->supervisors_1_by_semester_count,
            'supervisors_2_by_semester_count' => $this->supervisors_2_by_semester_count,
            'examiners_by_semester_count' => $this->examiners_by_semester_count,
            'chief_of_examiners_by_semester_count' => $this->chief_of_examiners_by_semester_count
        ];
    }
}
