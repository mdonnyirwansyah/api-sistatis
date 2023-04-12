<?php
namespace App\Services;

use App\Http\Resources\Seminar\SeminarResource;
use App\Models\CounterOfLetter;
use App\Models\Seminar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeminarService
{
    public static function getAll($request)
    {
        if ($request->status) {
            return Seminar::with([
                'thesis',
                'thesis.student',
            ])
            ->where('type', $request->type)
            ->where('status', $request->status)
            ->orderBy('register_date', 'DESC')
            ->paginate(5);
        } else {
            return Seminar::with([
                'thesis',
                'thesis.student',
            ])
            ->where('type', $request->type)
            ->orderBy('date', 'DESC')
            ->paginate(5);
        }
    }

    public static function register($request)
    {
        $student = ThesisService::getByNim($request->student['nim']);

        $exist = Seminar::where('thesis_id', $student->thesis->id)
            ->where('type', $request->student['seminar']['type'])
            ->first();

        if ($exist) {
            $response = [
                'data' => [],
                'code' => 422,
                'status' => 'Unprocessable Content',
                'message' => 'Data sebelumnya sudah ada'
            ];

            return response()->json($response, 422);
        }

        try {
            DB::beginTransaction();

            $seminar = Seminar::create([
                'thesis_id' => $student->thesis->id,
                'type' => $request->student['seminar']['type'],
                'register_date' => $request->student['seminar']['register_date'],
                'semester' => $request->student['semester']
            ]);

            $examiners = collect($request->student['seminar']['examiners']);

            $seminar->lecturers()->sync($examiners->whereIn('status', ['Penguji 1', 'Penguji 2', 'Penguji 3']));

            if ($examiners->where('status', 'Ketua Sidang') && $request->type === 'Sidang Tugas Akhir') {
                $seminar->chiefOfExaminer()->create([
                    'lecturer_id' => $examiner->where('status', 'Ketua Sidang')->lecturer_id
                ]);
            }

            $status;

            switch ($request->student['seminar']['type']) {
                case 'Sidang Tugas Akhir':
                    $status = 3;
                    break;

                case 'Seminar Hasil Tugas Akhir':
                    $status = 2;
                    break;

                default:
                    $status = 1 ;
                    break;
            }

            $seminar->thesis()->update([
                'status' => $status
            ]);

            DB::commit();

            $seminarService = new Self();

            $response = [
                'data' => new SeminarResource($seminarService->getById($seminar->id)),
                'code' => 201,
                'status' => 'Created',
                'message' => 'Data berhasil ditambah'
            ];

            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollback();

            $response = [
                'data' => [],
                'code' => 500,
                'status' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    public static function getById($id)
    {
        return Seminar::where('id', $id)->with([
            'thesis',
            'thesis.field',
            'thesis.lecturers' => function ($query) {
                $query->orderBy('pivot_status', 'asc');
            },
            'thesis.student',
            'location',
            'lecturers' => function ($query) {
                $query->orderBy('pivot_status', 'asc');
            },
            'chiefOfExaminer',
            'chiefOfExaminer.lecturer'
        ])
        ->firstOrFail();
    }

    public static function schedule($request, $id)
    {
        $seminarService = new Self();
        $seminar = $seminarService->getById($id);

        if ($seminar->status !== 'Pendaftaran') {
            $response = [
                'data' => [],
                'code' => 422,
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar belum didaftarkan atau sudah terjadwal'
            ];
            return response()->json($response, 422);
        }

        try {
            $seminar->update([
                'date' => $request->seminar['date'],
                'time' => $request->seminar['time'],
                'location_id' => $request->seminar['location_id'],
                'status' => 1
            ]);

            $response = [
                'data' => new SeminarResource($seminarService->getById($seminar->id)),
                'code' => 200,
                'status' => 'OK',
                'message' => 'Data berhasil dijadwalkan'
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'data' => [],
                'code' => 500,
                'status' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    public static function serialNumber($seminarType)
    {
        switch ($seminarType) {
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

        return $number .'/'. $type .'/TS-S1/'. $month .'/'. $year;
    }

    public static function validate($id)
    {
        $seminarService = new Self();
        $seminar = $seminarService->getById($id);

        if ($seminar->status !== 'Penjadwalan') {
            $response = [
                'data' => [],
                'code' => 422,
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar belum dijadwalkan'
            ];

            return response()->json($response, 422);
        }

        try {
            DB::beginTransaction();
            $numberOfLetter = $seminarService->serialNumber($seminar->type);

            $seminar->update([
                'status' => 2,
                'number_of_letter' => $numberOfLetter,
                'validate_date' => date('Y-m-d')
            ]);

            if ($seminar->name == 'Sidang Tugas Akhir') {
                $seminar->thesis->update([
                    'finish_date' => $seminar->date
                ]);
            }

            DB::commit();

            $response = [
                'data' => new SeminarResource($seminarService->getById($seminar->id)),
                'code' => 200,
                'status' => 'OK',
                'message' => 'Data berhasil divalidasi'
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'data' => [],
                'code' => 500,
                'status' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    public static function update($request, $id)
    {
        $seminarService = new Self();
        $seminar = $seminarService->getById($id);

        try {
            DB::beginTransaction();

            $seminar->update([
                'register_date' => $request->seminar['register_date'],
                'semester' => $request->seminar['semester'],
                'date' => $request->seminar['date'],
                'time' => $request->seminar['time'],
                'location_id' => $request->seminar['location_id'],
                'status' => $request->seminar['status']
            ]);

            $examiners = collect($request->student['seminar']['examiners']);

            $seminar->lecturers()->sync($examiners->whereIn('status', ['Penguji 1', 'Penguji 2', 'Penguji 3']));

            if ($examiners->where('status', 'Ketua Sidang') && $request->type === 'Sidang Tugas Akhir') {
                $seminar->chiefOfExaminer()->update([
                    'lecturer_id' => $examiner->where('status', 'Ketua Sidang')->lecturer_id
                ]);
            }

            DB::commit();

            $response = [
                'data' => new SeminarResource($seminarService->getById($seminar->id)),
                'code' => 200,
                'status' => 'OK',
                'message' => 'Data berhasil diubah'
            ];

            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollback();

            $response = [
                'data' => [],
                'code' => 500,
                'status' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    public static function delete($id)
    {
        $seminarService = new Self();
        $seminar = $seminarService->getById($id);

        try {
            DB::beginTransaction();

            $thesisStatus;

            switch ($seminar->type) {
                case 'Sidang Tugas Akhir':
                    $thesisStatus = 2;
                    break;

                case 'Seminar Hasil Tugas Akhir':
                    $thesisStatus = 1;
                    break;

                default:
                    $thesisStatus = 0;
                    break;
            }

            $seminar->thesis->update([
                'status' => $thesisStatus
            ]);

            $seminar->delete();

            DB::commit();

            $response = [
                'data' => [],
                'code' => 200,
                'status' => 'OK',
                'message' => 'Data berhasil dihapus'
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'data' => [],
                'code' => 500,
                'status' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];

            return response()->json($response);
        }
    }

    public static function undangan($id)
    {
        $seminarService = new Self();
        $seminar = $seminarService->getById($id);

        if ($seminar->status !== 'Validasi') {
            $response = [
                'data' => [],
                'code' => '422',
                'status' => 'Unprocessable Content',
                'message' => 'Data seminar belum divalidasi'
            ];
            return response()->json($response, 422);
        }

        $lecturers = [];

        foreach ($key->thesis->supervisors() as $supervisor) {
            $add = [
                'name' => $supervisor->name
            ];
            array_push($lecturers, $add);
        }

        foreach ($seminar->examiners() as $examiner) {
            $add = [
                'name' => $examiner->name,
            ];
            array_push($lecturers, $add);
        }

        if ($seminar->chiefOfExaminer) {
            $chiefOfExaminer = [
                'name' => $key->chiefOfExaminer->lecturer->name
            ];

            array_unshift($lecturers, $chiefOfExaminer);
        }

        $date = Carbon::parse($seminar->date)->locale('id');
        $validateDate = Carbon::parse($seminar->validate_date)->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        $validateDate->settings(['formatFunction' => 'translatedFormat']);
        $qrcode = base64_encode(QrCode::format('svg')->size(75)->errorCorrection('H')->generate($seminar->number_of_letter));

        $data = [
            'id' => $seminar->id,
            'lecturers' => $lecturers,
            'student' => [
                'name' => $seminar->thesis->student->name
            ],
            'seminar' => [
                'validate_date' => $validateDate->format('j F Y'),
                'type' => $seminar->type,
                'date' => $date->format('l, j F Y'),
                'time' => Carbon::parse($key->time)->format('H:i'),
                'location' => $seminar->location->name
            ],
            'sign' => $qrcode
        ];

        $pdf = Pdf::loadView('pdf.undangan', compact('data'))
        ->setPaper('a4')->setOption('margin-top', '1cm')->setOption('margin-bottom', '1cm')->setOption('margin-left', '3cm')->setOption('margin-right', '3cm');

        return $pdf->download('undangan.pdf');
    }

    public static function beritaAcara()
    {
        //
    }
}
