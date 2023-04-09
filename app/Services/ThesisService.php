<?php
namespace App\Services;

use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThesisService
{
    public static function getAll($request)
    {
        if ($request->student_status !== null && $request->field_id !== null) {
            $theses = Student::with(['thesis', 'thesis.field'])
                ->whereHas('thesis', function (Builder $query) use ($request) {
                    $query->where('field_id', $request->field_id)->orderBy('register_date', 'desc');
                })
                ->where('status', $request->student_status)
                ->paginate(5);
        } else {
            $theses = Student::with(['thesis', 'thesis.field'])
                ->whereHas('thesis', function (Builder $query) {
                    $query->orderBy('register_date', 'desc');
                })
                ->paginate(5);
        }

        return $theses;
    }

    public static function getByLecturer($request)
    {
        if ($request->lecturer_status == 'Pembimbing 1' || $request->lecturer_status == 'Pembimbing 2') {
            $theses = Student::with(['thesis', 'thesis.field'])
                ->whereHas('thesis.lecturers', function (Builder $query) use ($request) {
                    $query->where('id', $request->lecturer_id)->where('lecturerables.status', $request->lecturer_status);
                })
                ->where('status', $request->student_status)
                ->whereHas('thesis', function (Builder $query) {
                    $query->orderBy('register_date', 'DESC');
                })
                ->paginate(5);
        } else {
            $theses = Student::with(['thesis', 'thesis.field'])
                ->whereHas('thesis.seminars.lecturers', function (Builder $query) use ($request) {
                    $query->where('id', $request->lecturer_id);
                })
                ->where('status', $request->student_status)
                ->whereHas('thesis', function (Builder $query) {
                    $query->orderBy('register_date', 'DESC');
                })
                ->paginate(5);
        }

        return $theses;
    }

    public static function getClassification()
    {
        return Student::with('thesis')->where('status', 1)->whereNotNull('graduate_date')->paginate(5);
    }

    public static function create($request)
    {
        try {
            DB::beginTransaction();

            $student = Student::create([
                'name' => $request->student['name'],
                'nim' => $request->student['nim'],
                'phone' => $request->student['phone'],
                'register_date' => Str::padLeft(Str::substr($request->student['nim'], 0, 2), 4, '20'). '-' .Str::substr($request->student['nim'], 2, 2). '-01',
                'generation' => Str::padLeft(Str::substr($request->student['nim'], 0, 2), 4, '20')
            ]);

            $student->thesis()->create([
                'register_date' => $request->student['thesis']['register_date'],
                'title' => $request->student['thesis']['title'],
                'field_id' => $request->student['thesis']['field_id'],
                'semester' => $request->student['thesis']['semester'],
            ]);

            $student->thesis->lecturers()->sync($request->student['thesis']['supervisors']);

            DB::commit();

            $thesisService = new Self();
            $created = $thesisService->getById($student->thesis->id);

            $response = [
                'data' => new StudentResource($created),
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
        $thesis = Student::with([
            'thesis',
            'thesis.field',
            'thesis.lecturers' => function ($query) {
                $query->orderBy('pivot_status', 'asc');
            },
            'thesis.seminars',
            'thesis.seminars.location',
            'thesis.seminars.lecturers' => function ($query) {
                $query->orderBy('pivot_status', 'asc');
            },
            'thesis.seminars.chiefOfExaminer',
            'thesis.seminars.chiefOfExaminer.lecturer'
        ])
        ->whereRelation('thesis', 'id', $id)
        ->firstOrFail();

        return $thesis;
    }

    public static function getByNim($nim)
    {
        $thesis = Student::with([
            'thesis',
            'thesis.field',
            'thesis.lecturers'
        ])
            ->where('nim', $nim)
            ->firstOrFail();

        return $thesis;
    }

    public static function update($request, $id)
    {
        try {
            DB::beginTransaction();

            $student = Student::whereRelation('thesis', 'id', $id)
            ->firstOrFail();

            $student->update([
                'name' => $request->student['name'],
                'nim' => $request->student['nim'],
                'phone' => $request->student['phone'],
                'register_date' => $request->student['register_date'],
                'generation' => $request->student['generation'],
                'status' => $request->student['status'],
                'graduate_date' => $request->student['graduate_date'],
                'gpa' => $request->student['gpa']
            ]);

            $student->thesis()->update([
                'register_date' => $request->student['thesis']['register_date'],
                'title' => $request->student['thesis']['title'],
                'field_id' => $request->student['thesis']['field_id'],
                'semester' => $request->student['thesis']['semester'],
                'finish_date' => $request->student['thesis']['finish_date'],
                'status' => $request->student['thesis']['status'],
            ]);

            $student->thesis->lecturers()->sync($request->student['thesis']['supervisors']);

            DB::commit();

            $thesisService = new Self();

            $response = [
                'data' => new StudentResource($thesisService->getById($student->thesis->id)),
                'code' => '200',
                'status' => 'OK',
                'message' => 'Data berhasil diubah'
            ];

            return response()->json($response, 200);
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
        $thesisService = new Self();
        $student = $thesisService->getById($id);

        try {
            DB::beginTransaction();

            $student->delete();

            DB::commit();

            $response = [
                'data' => $student,
                'code' => '200',
                'status' => 'OK',
                'message' => 'Data berhasil dihapus'
            ];

            return response()->json($response, 200);
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
}
