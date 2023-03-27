<?php

namespace App\Http\Controllers;

use App\Http\Resources\SemesterCollection;
use App\Models\Seminar;
use App\Models\Thesis;

class SemesterController extends Controller
{
    public function index() {
        $theses = collect(Thesis::select('semester')->orderBy('semester', 'DESC')->groupBy('semester')->get());
        $seminars = collect(Seminar::select('semester')->orderBy('semester', 'DESC')->groupBy('semester')->get());
        $collection = $theses->merge($seminars);
        $collection = $collection->unique('semester');
        $semester = $collection->sortBy([
            ['semester', 'desc']
        ]);

        return new SemesterCollection($semester);
    }
}
