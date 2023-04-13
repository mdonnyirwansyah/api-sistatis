<?php

namespace App\Http\Controllers;

use App\Http\Resources\Seminar\SeminarCollection;
use App\Http\Resources\Seminar\SeminarResource;
use App\Http\Requests\SeminarRegisterRequest;
use App\Http\Requests\SeminarScheduleRequest;
use App\Http\Requests\SeminarUpdateRequest;
use App\Services\SeminarService;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    public function index(Request $request)
    {
        return new SeminarCollection(SeminarService::getAll($request));
    }

    public function register(SeminarRegisterRequest $request)
    {
        return SeminarService::register($request);
    }

    public function show($id)
    {
        return (new SeminarResource(SeminarService::getById($id)))->additional([
            'data' => [],
            'code' => 200,
            'status' => 'OK',
            'message' => 'Thesis data by id'
        ]);
    }

    public function update(SeminarUpdateRequest $request, $id)
    {
        return SeminarService::update($request, $id);
    }

    public function schedule(SeminarScheduleRequest $request, $id)
    {
        return SeminarService::schedule($request, $id);
    }

    public function validated($id)
    {
        return SeminarService::validate($id);
    }

    public function destroy($id)
    {
        return SeminarService::delete($id);
    }

    public function undangan($id)
    {
        return SeminarService::undangan($id);
    }

    public function beritaAcara($id)
    {
        return SeminarService::beritaAcara($id);
    }
}
