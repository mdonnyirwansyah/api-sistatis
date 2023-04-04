<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeminarCollection;
use App\Http\Resources\SeminarResource;
use App\Http\Requests\SeminarRequest;
use App\Http\Requests\SeminarScheduleRequest;
use App\Models\Seminar;
use App\Models\Thesis;
use App\Models\Lecturer;
use App\Models\CounterOfLetter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use QrCode;

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
            ->paginate(5);

            return new SeminarCollection($seminars);
        } else {
            $seminars = Seminar::with([
                'thesis',
                'thesis.student',
            ])
            ->where('name', $request->name)
            ->orderBy('date', 'DESC')
            ->paginate(5);

            return new SeminarCollection($seminars);
        }
    }

    public function store(SeminarRequest $request)
    {
        $existSeminar = Seminar::where('thesis_id', $request->thesis_id)->where('name', $request->name)->first();

        if ($existSeminar) {
            $response = [
                'data' => [],
                'code' => '422',
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar sudah ada'
            ];

            return response()->json($response, 422);
        }
        DB::transaction(function () use ($request) {
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
                'name' => $request->name,
                'register_date' => $request->register_date,
                'semester' => $request->semester,
                'status' => 'Pendaftaran'
            ]);

            $seminar->lecturers()->sync($examiners);

            if ($request->chief_of_examiner && $request->name == 'Sidang Tugas Akhir') {
                $seminar->chiefOfExaminer()->create([
                    'lecturer_id' => $request->chief_of_examiner
                ]);
            }

            $thesis = Thesis::find($request->thesis_id);

            $thesis->update([
                'status' => $request->name
            ]);
        });

        $response = [
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil ditambah'
        ];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $seminar = Seminar::where('id', $id)->with([
            'thesis',
            'thesis.field',
            'thesis.lecturers' => function ($q) {
                $q->orderBy('pivot_status', 'asc');
            },
            'thesis.student',
            'location',
            'lecturers' => function ($q) {
                $q->orderBy('pivot_status', 'asc');
            },
            'chiefOfExaminer',
            'chiefOfExaminer.lecturer'
        ])
        ->firstOrFail();

        return (new SeminarResource($seminar))->additional([
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Seminar data by id'
        ]);
    }

    public function update(SeminarRequest $request, Seminar $seminar)
    {
        DB::transaction(function () use ($request, $seminar) {
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
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil diubah'
        ];

        return response()->json($response, 200);
    }

    public function scheduleUpdate(SeminarScheduleRequest $request, Seminar $seminar)
    {
        if ($seminar->status !== 'Pendaftaran') {
            $response = [
                'data' => [],
                'code' => '422',
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar belum didaftarkan atau sudah terjadwal'
            ];
            return response()->json($response, 422);
        }

        DB::transaction(function () use ($request, $seminar) {
            $seminar->update([
                'date' => $request->date,
                'time' => $request->time,
                'location_id' => $request->location,
                'status' => 'Penjadwalan',
            ]);
        });

        $response = [
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil dijadwalkan'
        ];

        return response()->json($response, 200);
    }

    public function validateUpdate(Request $request, Seminar $seminar)
    {
        if ($seminar->status !== 'Penjadwalan') {
            $response = [
                'data' => [],
                'code' => '422',
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar belum dijadwalkan'
            ];
            return response()->json($response, 422);
        }

        DB::transaction(function () use ($request, $seminar) {
            switch ($seminar->name) {
                case 'Seminar Proposal Tugas Akhir':
                    $type = 'SP';
                    break;

                case 'Seminar Hasil Tugas Akhir':
                    $type = 'SH';
                    break;

                default:
                    $type = 'SS';
                    break;
            }
            $year = date('Y');
            $month = date('m');
            switch ($month) {
                case 1:
                    $month = 'I';
                    break;

                case 2:
                    $month = 'II';
                    break;

                case 3:
                    $month = 'III';
                    break;

                case 4:
                    $month = 'IV';
                    break;

                case 5:
                    $month = 'V';
                    break;

                case 6:
                    $month = 'VI';
                    break;

                case 7:
                    $month = 'VII';
                    break;

                case 8:
                    $month = 'VIII';
                    break;

                case 9:
                    $month = 'IX';
                    break;

                case 10:
                    $month = 'X';
                    break;

                case 11:
                    $month = 'XI';
                    break;

                default:
                    $month = 'XII';
                    break;
            }
            $maxLength = 3;
            $numberOfLetter = null;

            $counterOfLetter = CounterOfLetter::where('type', $type)->where('year', $year)->first();
            if ($counterOfLetter) {
                $counterOfLetter->increment('value', 1);
                $counterOfLetter->fresh();
            } else {
                $counterOfLetter = new CounterOfLetter();
                $counterOfLetter->type = $type;
                $counterOfLetter->year = $year;
                $counterOfLetter->value = 1;
                $counterOfLetter->save();
            }
            $number = Str::padLeft($counterOfLetter->value, $maxLength, '0');
            $numberOfLetter = $number .'/'. $type .'/TS-S1/'. $month .'/'. $year;
            $seminar->update([
                'status' => 'Validasi',
                'number_of_letter' => $numberOfLetter,
                'validate_date' => date('Y-m-d')
            ]);

            if ($seminar->name == 'Sidang Tugas Akhir') {
                $seminar->thesis->update([
                    'finish_date' => $seminar->date
                ]);
            }
        });

        $response = [
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil divalidasi'
        ];

        return response()->json($response, 200);
    }

    public function destroy(Seminar $seminar)
    {
        DB::transaction(function () use ($seminar) {
            switch ($seminar->name) {
                case 'Sidang Tugas Akhir':
                    $thesisStatus = 'Seminar Hasil Tugas Akhir';
                    break;

                case 'Seminar Hasil Tugas Akhir':
                    $thesisStatus = 'Seminar Proposal Tugas Akhir';
                    break;

                default:
                    $thesisStatus = 'Pendaftaran Tugas Akhir';
                    break;
            }

            $seminar->thesis->update([
                'status' => $thesisStatus
            ]);

            $seminar->delete();
        });

        $response = [
            'data' => [],
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil dihapus'
        ];

        return response()->json($response, 200);
    }

    public function undangan(Seminar $seminar)
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
        $student = [
            'name' => $key->thesis->student->name,
            'nim' => $key->thesis->student->nim,
            'phone' => $key->thesis->student->phone
        ];
        $lecturers = [];

        foreach ($key->thesis->lecturers as $supervisor) {
            $add = [
                'name' => $supervisor->name
            ];
            array_push($lecturers, $add);
        }

        $thesis = [
            'title' => $key->thesis->title
        ];

        foreach ($key->lecturers as $examiner) {
            $add = [
                'name' => $examiner->name,
            ];
            array_push($lecturers, $add);
        }

        if ($key->chiefOfExaminer) {
            $chiefOfExaminer = [
                'name' => $key->chiefOfExaminer->lecturer->name
            ];

            array_unshift($lecturers, $chiefOfExaminer);
        }

        $date = Carbon::parse($key->date)->locale('id');
        $validateDate = Carbon::parse($key->validate_date)->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        $validateDate->settings(['formatFunction' => 'translatedFormat']);

        $seminar = [
            'validate_date' => $validateDate->format('j F Y'),
            'name' => $key->name,
            'date' => $date->format('l, j F Y'),
            'time' => Carbon::parse($key->time)->format('H:i'),
            'location' => $key->location->name
        ];

        $qrcode = base64_encode(QrCode::format('svg')->size(75)->errorCorrection('H')->generate($key->number_of_letter));

        $data = [
            'id' => $key->id,
            'number_of_letter' => $key->number_of_letter,
            'lecturers' => $lecturers,
            'student' => $student,
            'thesis' => $thesis,
            'seminar' => $seminar,
            'sign' => $qrcode
        ];

        $pdf = Pdf::loadView('pdf.undangan', compact('data'))
        ->setPaper('a4')->setOption('margin-top', '1cm')->setOption('margin-bottom', '1cm')->setOption('margin-left', '3cm')->setOption('margin-right', '3cm');

        return $pdf->download('undangan.pdf');
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
