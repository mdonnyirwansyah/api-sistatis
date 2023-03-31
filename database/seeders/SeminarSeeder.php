<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Seminar;
use App\Models\Thesis;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seminars = array(
            0 => array(
                    'register_date' => '2023-01-01',
                    'thesis_id' => 1,
                    'name' => 'Seminar Proposal Tugas Akhir',
                    'date' => '2023-01-07',
                    'time' => '14:00:00',
                    'location_id' => 1,
                    'semester' => 'Genap 2022/2023',
                    'status' => 'Penjadwalan',
                    'validate_date' => null,
                    'examiners' => array(
                        0 => array(
                            'lecturer_id' => 4,
                            'status' => 'Penguji 1'
                        ),
                        1 => array(
                            'lecturer_id' => 6,
                            'status' => 'Penguji 2'
                        ),
                        2 => array(
                            'lecturer_id' => 2,
                            'status' => 'Penguji 3'
                        )
                    )
            ),
            1 => array(
                    'register_date' => '2023-01-27',
                    'thesis_id' => 2,
                    'name' => 'Seminar Proposal Tugas Akhir',
                    'date' => null,
                    'time' => null,
                    'location_id' => null,
                    'semester' => 'Genap 2022/2023',
                    'status' => 'Pendaftaran',
                    'validate_date' => null,
                    'examiners' => array(
                        0 => array(
                            'lecturer_id' => 4,
                            'status' => 'Penguji 1'
                        ),
                        1 => array(
                            'lecturer_id' => 3,
                            'status' => 'Penguji 2'
                        ),
                        2 => array(
                            'lecturer_id' => 5,
                            'status' => 'Penguji 3'
                        )
                    )
                )
        );

        foreach ($seminars as $seminar) {
            DB::transaction(function() use($seminar) {
                $created = Seminar::create([
                    'register_date' => $seminar['register_date'],
                    'thesis_id' => $seminar['thesis_id'],
                    'name' => $seminar['name'],
                    'date' => $seminar['date'],
                    'time' => $seminar['time'],
                    'location_id' => $seminar['location_id'],
                    'semester' => $seminar['semester'],
                    'status' => $seminar['status'],
                    'validate_date' => $seminar['validate_date']
                ]);

                $created->lecturers()->sync($seminar['examiners']);

                $thesis = Thesis::find($seminar['thesis_id']);
                $thesis->update([
                    'status' => $seminar['name']
                ]);
            });
        }
    }
}
