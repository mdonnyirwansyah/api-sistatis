<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => StudentResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'All location data'
        ];
    }
}
