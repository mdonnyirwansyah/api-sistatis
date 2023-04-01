<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThesisCollection;
use App\Http\Resources\ThesisResource;
use App\Http\Requests\ThesisRequest;
use App\Imports\ThesisImport;
use App\Models\Student;
use App\Models\Thesis;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ThesisController extends Controller
{
    public function index()
    {
        $theses = Thesis::with('student')
        ->orderBy('register_date', 'DESC')
        ->paginate(5);

        return new ThesisCollection($theses);
    }

    public function filter(Request $request)
    {
        $theses = Thesis::with('student')
        ->orderBy('register_date', 'DESC')
        ->whereRelation('student', 'status', $request->status)
        ->where('field_id', $request->field)
        ->orderBy('register_date', 'DESC')->paginate(5);

        return new ThesisCollection($theses);
    }

    public function store(ThesisRequest $request)
    {
        DB::transaction(function() use($request) {
            $supervisors = [];
            $supervisors[0] = [
                'lecturer_id' => $request->supervisor_1,
                'status' => 'Pembimbing 1'
            ];
            $supervisors[1] = [
                'lecturer_id' => $request->supervisor_2,
                'status' => 'Pembimbing 2'
            ];

            $student = Student::create([
                'name' => $request->name,
                'nim' => $request->nim,
                'phone' => $request->phone,
                'generation' => Str::padLeft(Str::substr($request->nim, 0, 2), 4, '20')
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
            'data' => [],
            'code' => '201',
            'status' => 'Created',
            'message' => 'Data berhasil ditambah'
        ];

        return response()->json($response, 201);
    }

    public function show($id)
    {
        $thesis = Thesis::where('id', $id)->with([
            'field',
            'lecturers' => function ($q) {
                $q->orderBy('pivot_status', 'asc');
            },
            'student',
            'seminars',
            'seminars.location',
            'seminars.lecturers' => function ($q) {
                $q->orderBy('pivot_status', 'asc');
            }
        ])
        ->firstOrFail();

        return (new ThesisResource($thesis))->additional([
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Thesis data by id'
        ]);
    }

    public function showByNim(Request $request)
    {
        $thesis = Thesis::with([
            'field',
            'lecturers',
            'student',
        ])
        ->whereRelation('student', 'nim', $request->nim)
        ->first();

        if (!$thesis) {
            $data = [];

            $response = [
                'data' => $data,
                'code' => '404',
                'status' => 'Not Found',
                'message' => 'Data tidak ditemukan'
            ];

            return response()->json($response, 404);
        }

        return (new ThesisResource($thesis))->additional([
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Thesis data by nim'
        ]);
    }

    public function update(ThesisRequest $request, Thesis $thesis)
    {
        DB::transaction(function() use($request, $thesis) {
            $supervisors = [];
            $supervisors[0] = [
                'lecturer_id' => $request->supervisor_1,
                'status' => 'Pembimbing 1'
            ];
            $supervisors[1] = [
                'lecturer_id' => $request->supervisor_2,
                'status' => 'Pembimbing 2'
            ];

            $student = Student::find($thesis->student_id);

            $student->update([
                'name' => $request->name,
                'nim' => $request->nim,
                'phone' => $request->phone,
                'generation' => Str::padLeft(Str::substr($request->nim, 0, 2), 4, '20'),
                'status' => $request->status,
            ]);

            $thesis->update([
                'register_date' => $request->register_date,
                'title' => $request->title,
                'field_id' => $request->field
            ]);

            $thesis->lecturers()->sync($supervisors);
        });

        $response = [
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil diubah'
        ];

        return response()->json($response, 200);
    }

    public function destroy(Thesis $thesis)
    {
        $student = Student::find($thesis->student_id);
        $student->delete();

        $response = [
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil dihapus'
        ];

        return response()->json($response, 200);
    }

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
                'data' => [],
                'code' => '200',
                'status' => 'OK',
                'message' => 'Data berhasil diimport'
            ];

            return response()->json($response, 201);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json($failures, 422);
        }
    }
}
