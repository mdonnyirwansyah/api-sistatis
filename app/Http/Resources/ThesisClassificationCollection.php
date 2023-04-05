<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ThesisClassificationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ThesisClassificationResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'All thesis classification data'
        ];
    }
}
