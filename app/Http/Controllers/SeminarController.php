<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Thesis;
use App\Http\Requests\SeminarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use PDF;

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
        if ($request->status == 'Registered') {
            $seminars = Seminar::where('name', $request->name)->where('status', $request->status)->orderBy('register_date', 'DESC')->get();
            $data = [];
            foreach ($seminars as $index => $seminar) {
                $data[$index] = [
                    'id' => $seminar->id,
                    'register_date' => $seminar->register_date,
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
        } else if ($request->status == 'Scheduled') {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\SeminarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeminarRequest $request)
    {
        DB::transaction(function() use($request) {
            $examiners = [];
            $examiners[0] = [
                'lecturer_id' => $request->examiner_1,
                'status' => 'Penguji 1'
            ];
            $examiners[1] = [
                'lecturer_id' => $request->examiner_2,
                'status' => 'Penguji 2'
            ];
            $examiners[2] = [
                'lecturer_id' => $request->examiner_3,
                'status' => 'Penguji 3'
            ];

            $seminar = Seminar::create([
                'thesis_id' => $request->thesis_id,
                'name' => 'Seminar Proposal Tugas Akhir',
                'register_date' => $request->register_date,
                'semester' => $request->semester,
                'status' => 'Registered'
            ]);

            $seminar->lecturers()->sync($examiners);

            $thesis = Thesis::find($request->thesis_id);

            $thesis->student->update([
                'status' => 'Seminar Proposal Tugas Akhir'
            ]);
        });

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
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
            'id' => $key->thesis->student->id,
            'name' => $key->thesis->student->name,
            'nim' => $key->thesis->student->nim,
            'phone' => $key->thesis->student->phone,
            'status' => $key->thesis->student->status,
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
            'id' => $key->thesis->id,
            'register_date' => $key->thesis->register_date,
            'title' => $key->thesis->title,
            'field_id' => $key->thesis->field->id,
            'field' => $key->thesis->field->name,
            'supervisors' => $supervisors
        ];

        foreach ($key->lecturers as $index => $examiner) {
            $examiners[$index] = [
                'id' => $examiner->id,
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
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Seminar  $seminar
     * @param  \Illuminate\Http\Requests\SeminarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SeminarRequest $request, Seminar $seminar)
    {
        DB::transaction(function() use($request, $seminar) {
            $examiners = [];
            $examiners[0] = [
                'lecturer_id' => $request->examiner_1,
                'status' => 'Penguji 1'
            ];
            $examiners[1] = [
                'lecturer_id' => $request->examiner_2,
                'status' => 'Penguji 2'
            ];
            $examiners[2] = [
                'lecturer_id' => $request->examiner_3,
                'status' => 'Penguji 3'
            ];

            $seminar->update([
                'register_date' => $request->register_date,
                'semester' => $request->semester,
            ]);

            $seminar->lecturers()->sync($examiners);
        });

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function schedule_update(Request $request, Seminar $seminar)
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required'],
            'time' => ['required'],
            'location' => ['required']
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

        DB::transaction(function() use($request, $seminar) {
            $seminar->update([
                'date' => $request->date,
                'time' => $request->time,
                'location_id' => $request->location,
                'status' => 'Scheduled',
            ]);
        });

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function validate_update(Request $request, Seminar $seminar)
    {
        if($seminar->status !== 'Scheduled') {
            $response = [
                'code'=> '422',
                'status'=> 'Unprocessable Content',
                'data'=> ["status" => 'Not scheduled!']
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::transaction(function() use($request, $seminar) {
            $seminar->update([
                'status' => 'Validated',
            ]);
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
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seminar $seminar)
    {
        DB::transaction(function () use($seminar) {
            $seminar->delete();
            $seminar->thesis->student->update([
                'status' => 'Tugas Akhir'
            ]);
        });

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function print(Seminar $seminar)
    {
        if($seminar->status !== 'Validated') {
            $response = [
                'code'=> '422',
                'status'=> 'Unprocessable Content',
                'data'=> ["status" => 'Not validated!']
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $key = $seminar;
        $student = [
            'id' => $key->thesis->student->id,
            'name' => $key->thesis->student->name,
            'nim' => $key->thesis->student->nim,
            'phone' => $key->thesis->student->phone,
            'status' => $key->thesis->student->status,
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
            'id' => $key->thesis->id,
            'register_date' => $key->thesis->register_date,
            'title' => $key->thesis->title,
            'field_id' => $key->thesis->field->id,
            'field' => $key->thesis->field->name,
            'supervisors' => $supervisors
        ];

        foreach ($key->lecturers as $index => $examiner) {
            $examiners[$index] = [
                'id' => $examiner->id,
                'name' => $examiner->name,
                'status' => $examiner->pivot->status
            ];
        }
        $status_examiners = array_column($examiners, 'status');
        array_multisort($status_examiners, SORT_ASC, $examiners);
        $seminar = [
            'register_date' => $key->register_date,
            'status' => $key->status,
            'validate_date' => date_format(new \DateTime($key->date), 'd M Y'),
            'name' => $key->name,
            'date' => date_format(new \DateTime($key->date), 'D / d M Y'),
            'time' => date_format(new \DateTime($key->time), 'H:i'),
            'location' => $key->location->name,
            'examiners' => $examiners,
            'semester' => $key->semester
        ];

        $data = [
            'id' => $key->id,
            'student' => $student,
            'thesis' => $thesis,
            'seminar' => $seminar
        ];

        $pdf = PDF::loadView('pdf.undangan', compact('data'))
        ->setPaper('a4')->setOption('margin-top', '1cm')->setOption('margin-bottom', '1cm')->setOption('margin-left', '3cm')->setOption('margin-right', '3cm');

        return $pdf->download('undangan.pdf');
    }
}
