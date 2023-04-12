<?php

namespace App\Http\Controllers;

use App\Http\Resources\Seminar\SeminarCollection;
use App\Http\Resources\Seminar\SeminarResource;
use App\Http\Requests\SeminarRegisterRequest;
use App\Http\Requests\SeminarScheduleRequest;
use App\Http\Requests\SeminarUpdateRequest;
use App\Models\Seminar;
use App\Services\SeminarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use QrCode;

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

    public function beritaAcara(Seminar $seminar)
    {
        if ($seminar->status !== 'Validasi') {
            $response = [
                'data' => [],
                'code' => '422',
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar belum divalidasi'
            ];
            return response()->json($response, 422);
        }

        $key = $seminar;

        switch ($key->name) {
            case 'Sidang Tugas Akhir':
                $options = 'LULUS / TIDAK LULUS  *)';
                break;

            case 'Seminar Hasil Tugas Akhir':
                $options = 'DILANJUTKAN / DIBATALKAN  *) KE PROSES SIDANG TUGAS AKHIR';
                break;

            default:
                $options = 'DILANJUTKAN / DIBATALKAN  *) KE PROSES SEMINAR HASIL TUGAS AKHIR';
                break;
        }

        $student = [
            'name' => $key->thesis->student->name,
            'nim' => $key->thesis->student->nim,
        ];
        $lecturers = [];

        foreach ($key->thesis->lecturers as $supervisor) {
            $add = [
                'name' => $supervisor->name,
                'nip' => $supervisor->nip
            ];
            array_push($lecturers, $add);
        }

        $thesis = [
            'title' => $key->thesis->title,
        ];

        $date = Carbon::parse($key->date)->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);

        $seminar = [
            'status' => $key->status,
            'name' => $key->name,
            'date' => $date->format('j F Y'),
            'day_string' => $date->format('l'),
            'day' => $date->format('j'),
            'month' => $date->format('F'),
            'year' => $date->format('Y')

        ];

        $data = [
            'lecturers' => $lecturers,
            'student' => $student,
            'thesis' => $thesis,
            'seminar' => $seminar,
            'options' => $options
        ];

        $pdf = Pdf::loadView('pdf.berita-acara', compact('data'))
        ->setPaper('a4')->setOption('margin-top', '1cm')->setOption('margin-bottom', '1cm')->setOption('margin-left', '3cm')->setOption('margin-right', '3cm');

        return $pdf->download('berita-acara.pdf');
    }
}
