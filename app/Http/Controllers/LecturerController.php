<?php

namespace App\Http\Controllers;

use App\Imports\LecturerImport;
use App\Http\Resources\LecturerCollection;
use App\Http\Resources\LecturerResource;
use App\Http\Resources\LecturerClassificationCollection;
use App\Services\LecturerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LecturerController extends Controller
{
    public function index()
    {
        return new LecturerCollection(LecturerService::getAll());
    }

    public function classification(Request $request)
    {
        return new LecturerClassificationCollection(LecturerService::getClassification($request));
    }

    public function show($id)
    {
        return (new LecturerResource(LecturerService::getById($id)))->additional([
            'data' => [],
            'code' => 200,
            'status' => 'OK',
            'message' => 'Lecturer data by id'
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        $file = $request->file('file');

        if ($validator->fails()) {
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
}
