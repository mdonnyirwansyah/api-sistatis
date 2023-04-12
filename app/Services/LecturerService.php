<?php
namespace App\Services;

use App\Models\Lecturer;

class LecturerService
{

    public static function getAll()
    {
        return Lecturer::with('fields')->orderBy('name', 'ASC')->get();
    }

    public static function getClassification($request)
    {
        $semesterService = SemesterService::getAll();
        $semester = $request->semester ?? $semesterService->first()->semester;

        return Lecturer::with('fields')->select('id', 'nip', 'name', 'major')->withCount(['supervisors1', 'supervisors2', 'seminars AS examiners_count', 'chiefOfExaminers', 'supervisors1 AS supervisors_1_by_semester_count' => function ($q) use ($semester) {
            $q->where('semester', $semester);
        }, 'supervisors2 AS supervisors_2_by_semester_count' => function ($q) use ($semester) {
            $q->where('semester', $semester);
        }, 'seminars AS examiners_by_semester_count' => function ($q) use ($semester) {
            $q->where('semester', $semester);
        }, 'chiefOfExaminers AS chief_of_examiners_by_semester_count' => function ($q) use ($semester) {
            $q->whereRelation('seminar', 'semester', $semester);
        }])->paginate(5);
    }

    public static function getById($id)
    {
        return Lecturer::where('id', $id)->with(['fields' => function ($q) {
            $q->orderBy('pivot_status', 'asc');
        }])->firstOrFail();
    }
}
