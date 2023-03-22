<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChiefOfExaminerResource extends JsonResource
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
            'id' => $this->lecturer->id,
            'name' => $this->lecturer->name,
            'nip' => $this->lecturer->nip,
            'major' => $this->lecturer->major,
            'fields' => FieldResource::collection($this->whenLoaded('fields'))
        ];
    }
}
