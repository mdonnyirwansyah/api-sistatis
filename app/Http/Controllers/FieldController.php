<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::orderBy('name', 'ASC')->get();
        $data = [];
        foreach ($fields as $index => $field) {
            $data[$index] = [
                'id' => $field->id,
                'name' => $field->name,

            ];
        }

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'data'=> $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
