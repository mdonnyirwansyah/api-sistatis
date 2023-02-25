<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LocationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => LocationResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'All location data'
        ];
    }
}
