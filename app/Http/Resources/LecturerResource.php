<?php

namespace App\Http\Resources;

use App\Http\Resources\FieldResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturerResource extends JsonResource
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
        ];
    }
}
