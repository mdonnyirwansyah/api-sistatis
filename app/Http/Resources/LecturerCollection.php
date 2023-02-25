<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LecturerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => LecturerResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'All lecturer data'
        ];
    }
}
