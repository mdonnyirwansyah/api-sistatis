<?php

namespace App\Imports;

use App\Models\Thesis;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class ThesisImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $lecturers = [];
            $lecturers[0] = [
                'lecturer_id' => $row[6],
                'status' => 'Pembimbing 1'
            ];
            $lecturers[1] = [
                'lecturer_id' => $row[7],
                'status' => 'pembimbing 2'
            ];

            {
                DB::transaction(function() use($row, $lecturers) {
                    Student::create([
                        'id' => $row[1],
                        'name' => $row[2],
                        'phone' => $row[3],
                        'status' => 'Thesis Registered'
                    ]);

                    $thesis = Thesis::create([
                        'student_id' => $row[1],
                        'date_register' => $row[0],
                        'title' => $row[4],
                        'field_id' => $row[5]
                    ]);

                    $thesis->lecturers()->sync($lecturers);
                });
            }
        }
    }
}
