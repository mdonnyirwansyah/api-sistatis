<?php

namespace App\Http\Controllers;

use App\Imports\ThesisImport;
use App\Models\Student;
use App\Models\Thesis;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $theses = Thesis::orderBy('register_date', 'DESC')->get();
        $data = [];
        foreach ($theses as $index => $thesis) {
            $data[$index] = [
                'id' => $thesis->id,
                'register_date' => $thesis->register_date,
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
        $validator = Validator::make($request->all(), [
            'nim' => ['required'],
            'name' => ['required'],
            'phone' => ['required'],
            'register_date' => ['required'],
            'title' => ['required'],
            'field' => ['required'],
            'supervisors' => ['required']
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            $response = [
                'code'=> '422',
                'status'=> 'Unprocessable Content',
                'data'=> $errors
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::transaction(function() use($request) {
                Student::create([
                    'id' => $request->nim,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'status' => 'Thesis Registered'
                ]);

                $thesis = Thesis::create([
                    'student_id' => $request->nim,
                    'register_date' => $request->register_date,
                    'title' => $request->title,
                    'field_id' => $request->field
                ]);

                $thesis->lecturers()->sync($request->supervisors);

                $response = [
                    'code'=> '200',
                    'status'=> 'OK',
                    'data'=> $thesis
                ];

                return response()->json($response, Response::HTTP_CREATED);
            });
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed '. $e->errorInfo
            ]);
        }
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
            'register_date' => $key->register_date,
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
                'register_date' => $seminar->register_date,
                'status' => $seminar->status,
                'name' => $seminar->name,
                'date' => $seminar->date,
                'time' => $seminar->time,
                'location' => $seminar->location_id ? $seminar->location->name : null,
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
