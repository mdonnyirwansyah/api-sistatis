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
                'nim' => $thesis->student->nim,
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
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $students = Student::with(['thesis' => function ($q) {
            $q->orderBy('register_date', 'DESC');
          }])->where('status', $request->status)->whereRelation('thesis', 'field_id', $request->field)->get();
        $data = [];
        foreach ($students as $index => $student) {
            $data[$index] = [
                'id' => $student->thesis->id,
                'register_date' => $student->thesis->register_date,
                'nim' => $student->nim,
                'name' => $student->name,
                'title' => $student->thesis->title,
                'status' => $student->status
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
            'supervisor_1' => ['required'],
            'supervisor_2' => ['required'],
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

        DB::transaction(function() use($request) {
            $supervisors = collect($request->input('supervisors', []))->map(function ($supervisor) {
                return ['status' => $supervisor];
            });

            $student = Student::create([
                'name' => $request->name,
                'nim' => $request->nim,
                'phone' => $request->phone,
                'status' => 'Tugas Akhir'
            ]);

            $thesis = Thesis::create([
                'student_id' => $student->id,
                'register_date' => $request->register_date,
                'title' => $request->title,
                'field_id' => $request->field
            ]);

            $thesis->lecturers()->sync($supervisors);
        });

        $response = [
            'code'=> '201',
            'status'=> 'Created'
        ];

        return response()->json($response, Response::HTTP_CREATED);
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
            'id' => $key->student->id,
            'name' => $key->student->name,
            'nim' => $key->student->nim,
            'phone' => $key->student->phone,
            'status' => $key->student->status,
        ];
        foreach ($key->lecturers as $index => $supervisor) {
            $supervisors[$index] = [
                'id' => $supervisor->id,
                'name' => $supervisor->name,
                'status' => $supervisor->pivot->status
            ];
        }
        $status_supervisors = array_column($supervisors, 'status');
        array_multisort($status_supervisors, SORT_ASC, $supervisors);
        $thesis = [
            'register_date' => $key->register_date,
            'title' => $key->title,
            'field_id' => $key->field->id,
            'field' => $key->field->name,
            'supervisors' => $supervisors
        ];
        $seminars = [];
        foreach ($key->seminars as $index => $seminar) {
            foreach ($seminar->lecturers as $index1 => $examiner) {
                $examiners[$index1] = [
                    'id' => $examiner->id,
                    'name' => $examiner->name,
                    'status' => $examiner->pivot->status
                ];
            }
            $status_examiners = array_column($examiners, 'status');
            array_multisort($status_examiners, SORT_ASC, $examiners);
            $seminars[$index] = [
                'id' => $examiner->id,
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
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show_by_nim(Request $request)
    {
        $student = Student::where('nim', $request->nim)->first();

        if (!$student) {
            $data = [];

            $response = [
                'code'=> '404',
                'status'=> 'Not Found',
                'data'=> $data
            ];

            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        $key = $student;
        $student = [
            'id' => $key->id,
            'name' => $key->name,
            'nim' => $key->nim,
            'phone' => $key->phone,
            'status' => $key->status,
        ];
        foreach ($key->thesis->lecturers as $index => $supervisor) {
            $supervisors[$index] = [
                'id' => $supervisor->id,
                'name' => $supervisor->name,
                'status' => $supervisor->pivot->status
            ];
        }
        $status_supervisors = array_column($supervisors, 'status');
        array_multisort($status_supervisors, SORT_ASC, $supervisors);
        $thesis = [
            'register_date' => $key->thesis->register_date,
            'title' => $key->thesis->title,
            'field_id' => $key->thesis->field->id,
            'field' => $key->thesis->field->name,
            'supervisors' => $supervisors
        ];

        $data = [
            'id' => $key->id,
            'student' => $student,
            'thesis' => $thesis
        ];

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'data'=> $data
        ];

        return response()->json($response, Response::HTTP_OK);
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
        $validator = Validator::make($request->all(), [
            'nim' => ['required'],
            'name' => ['required'],
            'phone' => ['required'],
            'register_date' => ['required'],
            'title' => ['required'],
            'field' => ['required'],
            'supervisor_1' => ['required'],
            'supervisor_2' => ['required'],
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

        DB::transaction(function() use($request, $thesis) {
            $supervisors = collect($request->input('supervisors', []))->map(function ($supervisor) {
                return ['status' => $supervisor];
            });

            $student = Student::find($thesis->student_id);

            $student->update([
                'name' => $request->name,
                'nim' => $request->nim,
                'phone' => $request->phone,
            ]);

            $thesis->update([
                'register_date' => $request->register_date,
                'title' => $request->title,
                'field_id' => $request->field
            ]);

            $thesis->lecturers()->sync($supervisors);
        });

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thesis  $thesis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thesis $thesis)
    {
        $student = Student::find($thesis->student_id);
        $student->delete();

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
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
