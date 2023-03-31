<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThesisCollection;
use App\Models\Thesis;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->lecturer_status == 'Pembimbing 1' || $request->lecturer_status == 'Pembimbing 2') {
            $theses = Thesis::with(['student', 'field'])
            ->whereHas('lecturers', function ($q) use ($request) {
                $q->where('id', $request->lecturer_id)->where('lecturerables.status', $request->lecturer_status);
            })
            ->whereRelation('student', 'status', $request->student_status)
            ->orderBy('register_date', 'DESC')
            ->paginate(5);
        } else {
            $theses = Thesis::with(['student', 'field'])
            ->whereHas('seminars.lecturers', function ($q) use ($request) {
                $q->where('id', $request->lecturer_id);
            })
            ->whereRelation('student', 'status', $request->student_status)
            ->orderBy('register_date', 'DESC')
            ->paginate(5);
        }

        return new ThesisCollection($theses);
    }
}
