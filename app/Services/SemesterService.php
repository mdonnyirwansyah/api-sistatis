<?php
namespace App\Services;

use App\Models\Seminar;
use App\Models\Thesis;
use Illuminate\Support\Facades\DB;

class SemesterService
{
    public static function getAll()
    {
        $theses = collect(Thesis::select('semester', DB::raw('SUBSTRING(semester, -9) year'))->orderBy('semester', 'DESC')->groupBy('semester')->get());
        $seminars = collect(Seminar::select('semester', DB::raw('SUBSTRING(semester, -9) year'))->orderBy('semester', 'DESC')->groupBy('semester')->get());
        $collection = $theses->merge($seminars);
        $collection = $collection->unique('semester');
        return $collection->sortBy([
            ['year', 'desc'], ['semester', 'desc']
        ]);
    }
}
