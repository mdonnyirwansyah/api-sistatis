<?php

namespace App\Imports;

use App\Models\Lecturer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class LecturerImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $lecturerables = [];
            if ($row[4]) {
                $lecturerables[0] = [
                    'lecturerable_id' => $row[4],
                    'status' => 'Utama'
                ];
            }
            if ($row[5]) {
                $lecturerables[1] = [
                    'lecturerable_id' => $row[5],
                    'status' => 'Pilihan'
                ];
            }
            if ($row[6]) {
                $lecturerables[2] = [
                    'lecturerable_id' => $row[6],
                    'status' => 'Pilihan'
                ];
            }

            DB::transaction(function() use($row, $lecturerables) {
                $lecturer = Lecturer::create([
                    'id' => preg_replace('/\s+/', '',$row[0]),
                    'name' => $row[1],
                    'nip' => $row[0],
                    'major' => $row[2],
                    'status' => $row[3]
                ]);

                $lecturer->fields()->sync($lecturerables);

                return $lecturer;
            });
        }
    }
}
