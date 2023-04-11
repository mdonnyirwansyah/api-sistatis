<?php

namespace App\Http\Resources\Seminar;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeminarCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => SeminarResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'All thesis seminar data'
        ];
    }
}
