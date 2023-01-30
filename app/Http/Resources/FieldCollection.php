<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FieldCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => FieldResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK'
        ];
    }
}
