<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->status) {
            $seminars = Seminar::where('name', $request->name)->where('status', $request->status)->orderBy('date', 'DESC')->get();
            $data = [];
            foreach ($seminars as $index => $seminar) {
                $data[$index] = [
                    'id' => $seminar->id,
                    'date' => $seminar->date,
                    'name' => $seminar->thesis->student->name,
                    'title' => $seminar->thesis->title,
                ];
            }

            $response = [
                'code'=> '200',
                'status'=> 'OK',
                'data'=> $data
            ];

            return response()->json($response, Response::HTTP_OK);
        } else {
            $seminars = Seminar::where('name', $request->name)->orderBy('date', 'DESC')->get();
            $data = [];
            foreach ($seminars as $index => $seminar) {
                $data[$index] = [
                    'id' => $seminar->id,
                    'date' => $seminar->date,
                    'name' => $seminar->thesis->student->name,
                    'title' => $seminar->thesis->title,
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
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function show(Seminar $seminar)
    {
        $key = $seminar;
        $student = [
            'name' => $key->thesis->student->name,
            'nim' => $key->thesis->student_id,
            'phone' => $key->thesis->phone,
            'status' => $key->thesis->student->status,
        ];
        foreach ($key->thesis->lecturers as $index => $supervisor) {
            $supervisors[$index] = [
                'name' => $supervisor->name,
                'status' => $supervisor->pivot->status
            ];
        }
        $status_supervisors = array_column($supervisors, 'status');
        array_multisort($status_supervisors, SORT_ASC, $supervisors);
        $thesis = [
            'register_date' => $key->thesis->register_date,
            'title' => $key->thesis->title,
            'field' => $key->thesis->field->name,
            'supervisors' => $supervisors
        ];

        foreach ($key->lecturers as $index => $examiner) {
            $examiners[$index] = [
                'name' => $examiner->name,
                'status' => $examiner->pivot->status
            ];
        }
        $status_examiners = array_column($examiners, 'status');
        array_multisort($status_examiners, SORT_ASC, $examiners);
        $seminar = [
            'register_date' => $key->register_date,
            'status' => $key->status,
            'name' => $key->name,
            'date' => $key->date,
            'time' => $key->time,
            'location' => $key->location_id ? $key->location->name : null,
            'examiners' => $examiners,
            'semester' => $key->semester
        ];

        $data = [
            'id' => $key->id,
            'student' => $student,
            'thesis' => $thesis,
            'seminar' => $seminar
        ];

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
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function edit(Seminar $seminar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seminar $seminar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seminar $seminar)
    {
        //
    }
}
