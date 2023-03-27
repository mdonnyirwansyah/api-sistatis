<?php

namespace App\Http\Controllers;

use App\Imports\LecturerImport;
use App\Models\Lecturer;
use App\Models\Field;
use App\Models\Seminar;
use App\Models\Thesis;
use App\Http\Resources\LecturerCollection;
use App\Http\Resources\LecturerClassificationCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('fields')->orderBy('name', 'ASC')->get();

        return new LecturerCollection($lecturers);
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
            Excel::import(new LecturerImport, $file);

            $response = [
                'data' => [],
                'code' => '200',
                'status' => 'OK',
                'message' => 'Data berhasil diimport'
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json($failures, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function get_lecturers_by_field(Request $request)
    {
        $field = $request->id;
        $lecturers = Lecturer::whereHas('fields', function($query) use($field) {
            $query->where('id', $field);
        })->where('status', 'Aktif')->get();

        return new LecturerCollection($lecturers);
    }

    public function classification(Request $request)
    {
        $theses = collect(Thesis::select('semester')->orderBy('semester', 'DESC')->groupBy('semester')->get());
        $seminars = collect(Seminar::select('semester')->orderBy('semester', 'DESC')->groupBy('semester')->get());
        $collection = $theses->merge($seminars);
        $collection = $collection->unique('semester');
        $sorted = $collection->sortBy([
            ['semester', 'desc']
        ]);
        $sorted = $sorted->first();
        $semester = $request->semester ?? $sorted->semester;

        $lecturers = Lecturer::with('fields')->select('id', 'nip', 'name', 'major')->withCount(['supervisors1', 'supervisors2', 'seminars AS examiners_count', 'chiefOfExaminers', 'supervisors1 AS supervisors_1_by_semester_count' => function ($q) use ($semester) {
            $q->where('semester', $semester);
        }, 'supervisors2 AS supervisors_2_by_semester_count' => function ($q) use ($semester) {
            $q->where('semester', $semester);
        }, 'seminars AS examiners_by_semester_count' => function ($q) use ($semester) {
            $q->where('semester', $semester);
        }, 'chiefOfExaminers AS chief_of_examiners_by_semester_count' => function ($q) use ($semester) {
            $q->with('seminar', function ($q) use ($semester) {
                $q->where('semester', $semester);
            });
        }])->get();

        return new LecturerClassificationCollection($lecturers);
    }
}
