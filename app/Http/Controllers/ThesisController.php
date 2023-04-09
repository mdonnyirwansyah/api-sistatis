<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThesisCollection;
use App\Http\Resources\ThesisResource;
use App\Http\Resources\ThesisClassificationCollection;
use App\Http\Requests\ThesisStoreRequest;
use App\Http\Requests\ThesisUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Imports\ThesisImport;
use App\Models\Student;
use App\Models\Thesis;
use App\Services\ThesisService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ThesisController extends Controller
{
    public function index(Request $request)
    {
        return new StudentCollection(ThesisService::getAll($request));
    }

    public function filter(Request $request)
    {
        return new StudentCollection(ThesisService::getByLecturer($request));
    }

    public function classification()
    {
        return new ThesisClassificationCollection(ThesisService::getClassification());
    }

    public function store(ThesisStoreRequest $request)
    {
        return ThesisService::create($request);
    }

    public function show($id)
    {
        return (new StudentResource(ThesisService::getById($id)))->additional([
            'data' => [],
            'code' => 200,
            'status' => 'OK',
            'message' => 'Thesis data by id'
        ]);
    }

    public function showByNim($nim)
    {
        return (new StudentResource(ThesisService::getByNim($nim)))->additional([
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Thesis data by nim'
        ]);
    }

    public function update(ThesisUpdateRequest $request, $id)
    {
        return ThesisService::update($request, $id);
    }

    public function destroy($id)
    {
        return ThesisService::delete($id);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        $file = $request->file('file');

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
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
