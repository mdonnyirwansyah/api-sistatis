<?php

namespace App\Http\Controllers;

use App\Imports\ThesisImport;
use App\Models\Thesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ThesisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theses = Thesis::orderBy('date_register', 'DESC')->get();
        $data = [];
        foreach ($theses as $index => $thesis) {
            $data[$index] = [
                'id' => $thesis->id,
                'date_register' => $thesis->date_register,
                'nim' => $thesis->student_id,
                'name' => $thesis->student->name,
                'title' => $thesis->title,
                'status' => $thesis->student->status

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
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function show(Thesis $thesis)
    {
        $key = $thesis;
        $student = [
            'name' => $key->student->name,
            'nim' => $key->student_id,
            'status' => $key->student->status,
        ];
        foreach ($key->lecturers as $index => $supervisor) {
            $supervisors[$index] = [
                'name' => $supervisor->name,
                'status' => $supervisor->pivot->status
            ];
        }
        $status_supervisors = array_column($supervisors, 'status');
        array_multisort($status_supervisors, SORT_ASC, $supervisors);
        $thesis = [
            'date_register' => $key->date_register,
            'title' => $key->title,
            'field' => $key->field->name,
            'supervisors' => $supervisors
        ];
        $seminars = [];
        foreach ($key->seminars as $index => $seminar) {
            foreach ($seminar->lecturers as $index1 => $examiner) {
                $examiners[$index1] = [
                    'name' => $examiner->name,
                    'status' => $examiner->pivot->status
                ];
            }
            $status_examiners = array_column($examiners, 'status');
            array_multisort($status_examiners, SORT_ASC, $examiners);
            $seminars[$index] = [
                'date_register' => $seminar->date_register,
                'status' => $seminar->status,
                'name' => $seminar->name,
                'date' => $seminar->date,
                'time' => $seminar->time,
                'location' => $seminar->location->name,
                'examiners' => $examiners,
                'semester' => $seminar->semester
            ];
        }

        $data = [
            'id' => $key->id,
            'student' => $student,
            'thesis' => $thesis,
            'seminars' => $seminars
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
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function edit(Thesis $thesis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thesis $thesis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thesis $thesis)
    {
        //
    }

    /**
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function import(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'file' => 'required',
       ]);

       $file = $request->file('file');

       if($validator->fails()) {
           return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
       }

       try {
           Excel::import(new ThesisImport, $file);

           $response = [
               'code'=> '200',
               'status'=> 'OK'
           ];

           return response()->json($response, Response::HTTP_CREATED);
       } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
           $failures = $e->failures();
           return response()->json($failures, Response::HTTP_UNPROCESSABLE_ENTITY);
       }
   }
}
