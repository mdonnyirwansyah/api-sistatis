<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nip' => $this->nip,
            'major' => $this->major,
            'fields' => FieldResource::collection($this->whenLoaded('fields')),
            'status' => $this->whenPivotLoaded('lecturerables', function () {
                return $this->pivot->status;
            })
        ];
    }
}
