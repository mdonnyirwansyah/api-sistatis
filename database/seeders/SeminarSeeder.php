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
                    'register_date' => '2022-09-10',
                    'thesis_id' => 1,
                    'name' => 'Seminar Proposal Tugas Akhir',
                    'date' => '2022-12-10',
                    'time' => '14.00',
                    'location_id' => 1,
                    'semester' => 'Ganjil 2022/2023',
                    'status' => 'Scheduled',
                    'examiners' => array(
                        0 => array(
                            'lecturer_id' => 196907171998031002,
                            'status' => 'Penguji 1'
                        ),
                        1 => array(
                            'lecturer_id' => 196804131998031002,
                            'status' => 'Penguji 2'
                        ),
                        2 => array(
                            'lecturer_id' => 197308301999031001,
                            'status' => 'Penguji 3'
                        )
                    )
            ),
            1 => array(
                    'register_date' => '2022-12-27',
                    'thesis_id' => 2,
                    'name' => 'Seminar Proposal Tugas Akhir',
                    'date' => null,
                    'time' => null,
                    'location_id' => null,
                    'semester' => 'Ganjil 2022/2023',
                    'status' => 'Registered',
                    'examiners' => array(
                        0 => array(
                            'lecturer_id' => 198905012019031000,
                            'status' => 'Penguji 1'
                        ),
                        1 => array(
                            'lecturer_id' => 196806251995121001,
                            'status' => 'Penguji 2'
                        ),
                        2 => array(
                            'lecturer_id' => 196801271995121001,
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
                    'status' => $seminar['status']
                ]);

                $created->lecturers()->sync($seminar['examiners']);

                $thesis = Thesis::find($seminar['thesis_id']);
                $thesis->student->update([
                    'status' => 'Seminar Proposal Tugas Akhir'
                ]);
            });
        }
    }
}
