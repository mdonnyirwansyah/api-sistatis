<?php

namespace App\Http\Controllers;

use App\Imports\LecturerImport;
use App\Models\Lecturer;
use App\Models\Field;
use App\Http\Resources\LecturerCollection;
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
                'code'=> '200',
                'status'=> 'OK'
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
}
