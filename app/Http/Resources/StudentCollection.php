<?php

namespace App\Http\Resources;

use App\Http\Resources\StudentResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => StudentResource::collection($this->collection),
            'code'=> '200',
            'status'=> 'OK'
        ];
    }
}