<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ThesisCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ThesisResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'All thesis data'
        ];
    }
}
