<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Seminar;
use App\Models\Thesis;
use Carbon\Carbon;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seminars = [
            [
                'register_date' => '2023-01-01',
                'thesis_id' => 1,
                'name' => 'Seminar Proposal Tugas Akhir',
                'date' => '2023-01-07',
                'time' => '14:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2022/2023',
                'status' => 'Penjadwalan',
                'validate_date' => null,
                'examiners' => [
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 2,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2023-01-27',
                'thesis_id' => 2,
                'name' => 'Seminar Proposal Tugas Akhir',
                'date' => null,
                'time' => null,
                'location_id' => null,
                'semester' => 'Genap 2022/2023',
                'status' => 'Pendaftaran',
                'validate_date' => null,
                'examiners' => [
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 3,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-03-19',
                'thesis_id' => 3,
                'name' => 'Seminar Proposal Tugas Akhir',
                'date' => '2019-03-26',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-03-21',
                'examiners' => [
                    [
                        'lecturer_id' => 3,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-06-18',
                'thesis_id' => 3,
                'name' => 'Seminar Hasil Tugas Akhir',
                'date' => '2019-06-25',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-06-20',
                'examiners' => [
                    [
                        'lecturer_id' => 3,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-07-18',
                'thesis_id' => 3,
                'name' => 'Sidang Tugas Akhir',
                'date' => '2019-07-25',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-07-20',
                'chief_of_examiner' => 6,
                'examiners' => [
                    [
                        'lecturer_id' => 3,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-03-18',
                'thesis_id' => 4,
                'name' => 'Seminar Proposal Tugas Akhir',
                'date' => '2019-03-25',
                'time' => '10:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-03-20',
                'examiners' => [
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-06-11',
                'thesis_id' => 4,
                'name' => 'Seminar Hasil Tugas Akhir',
                'date' => '2019-06-18',
                'time' => '10:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-06-13',
                'examiners' => [
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-07-11',
                'thesis_id' => 4,
                'name' => 'Sidang Tugas Akhir',
                'date' => '2019-07-18',
                'time' => '10:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-07-13',
                'chief_of_examiner' => 7,
                'examiners' => [
                    [
                        'lecturer_id' => 4,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-03-19',
                'thesis_id' => 5,
                'name' => 'Seminar Proposal Tugas Akhir',
                'date' => '2019-03-26',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 'Validasi',
                'validate_date' => '2019-03-21',
                'examiners' => [
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 7,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-09-14',
                'thesis_id' => 5,
                'name' => 'Seminar Hasil Tugas Akhir',
                'date' => '2019-09-21',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Ganjil 2019/2020',
                'status' => 'Validasi',
                'validate_date' => '2019-09-16',
                'examiners' => [
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 7,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
            [
                'register_date' => '2019-10-14',
                'thesis_id' => 5,
                'name' => 'Sidang Tugas Akhir',
                'date' => '2019-10-21',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Ganjil 2019/2020',
                'status' => 'Validasi',
                'validate_date' => '2019-10-16',
                'chief_of_examiner' => 8,
                'examiners' => [
                    [
                        'lecturer_id' => 5,
                        'status' => 'Penguji 1'
                    ],
                    [
                        'lecturer_id' => 6,
                        'status' => 'Penguji 2'
                    ],
                    [
                        'lecturer_id' => 7,
                        'status' => 'Penguji 3'
                    ]
                ]
            ],
        ];

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

                if ($seminar['name'] == 'Sidang Tugas Akhir') {
                    $created->chiefOfExaminer()->create([
                        'lecturer_id' => $seminar['chief_of_examiner']
                    ]);
                    $thesis->update([
                        'finish_date' => $seminar['date']
                    ]);
                    $thesis->student->update([
                        'status' => 'Lulus',
                        'graduate_date' => Carbon::parse($seminar['date'])->addDays(7)
                    ]);
                }
            });
        }
    }
}
