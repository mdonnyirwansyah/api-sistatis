<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Thesis;
use App\Http\Resources\SeminarCollection;
use App\Http\Resources\SeminarResource;
use App\Http\Requests\SeminarRequest;
use App\Http\Requests\SeminarScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SeminarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->status) {
            $seminars = Seminar::with([
                'thesis',
                'thesis.student',
            ])
            ->where('name', $request->name)
            ->where('status', $request->status)
            ->orderBy('register_date', 'DESC')
            ->get();

            return new SeminarCollection($seminars);
        } else {
            $seminars = Seminar::with([
                'thesis',
                'thesis.student',
            ])
            ->where('name', $request->name)
            ->orderBy('date', 'DESC')
            ->get();

            return new SeminarCollection($seminars);
        }
    }

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
            'status'=> 'OK',
            'message' => 'Data berhasil ditambah'
        ];

        return response()->json($response, 200);
    }

    public function show(Seminar $seminar)
    {
        $seminar_id = $seminar->id;
        $seminar = Seminar::with([
            'thesis',
            'thesis.field',
            'thesis.lecturers',
            'thesis.student',
            'location',
            'lecturers'
        ])
        ->where('id', $seminar_id)
        ->first();

        return (new SeminarResource($seminar))->additional([
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'Seminar data by id'
        ]);
    }

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
            'status'=> 'OK',
            'message' => 'Data berhasil diubah'
        ];

        return response()->json($response, 200);
    }

    public function schedule_update(SeminarScheduleRequest $request, Seminar $seminar)
    {
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
            'status'=> 'OK',
            'message' => 'Data berhasil diatur'
        ];

        return response()->json($response, 200);
    }

    public function validate_update(Request $request, Seminar $seminar)
    {
        if($seminar->status !== 'Scheduled') {
            $response = [
                'code'=> '422',
                'status'=> 'Unprocessable Content',
                'message' => 'Data seminar belum dijadwalkan'
            ];
            return response()->json($response, 422);
        }

        DB::transaction(function() use($request, $seminar) {
            $seminar->update([
                'status' => 'Validated',
            ]);
        });

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'message' => 'Data berhasil divalidasi'
        ];

        return response()->json($response, 200);
    }

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
            'status'=> 'OK',
            'message' => 'Data berhasil dihapus'
        ];

        return response()->json($response, 200);
    }

    public function print(Seminar $seminar)
    {
        if($seminar->status !== 'Validated') {
            $response = [
                'code'=> '422',
                'status'=> 'Unprocessable Content',
                'message' => 'Data seminar belum divalidasi'
            ];
            return response()->json($response, 422);
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
