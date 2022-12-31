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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function lecturers(Field $field)
    {
        $data = [];
        foreach ($field->lecturers as $index => $lecturer) {
            $data[$index] = [
                'id' => $lecturer->id,
                'name' => $lecturer->name,

            ];
        }
        $name_data = array_column($data, 'name');
        array_multisort($name_data, SORT_ASC, $data);

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'data'=> $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        //
    }
}
