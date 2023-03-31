<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nim' => $this->nim,
            'phone' => $this->phone,
            'generation' => $this->generation,
            'status' => $this->status,
        ];
    }
}
