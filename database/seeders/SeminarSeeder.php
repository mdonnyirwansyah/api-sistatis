<?php

namespace Database\Seeders;

use App\Models\CounterOfLetter;
use App\Models\Seminar;
use App\Models\Thesis;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'type' => 'Seminar Proposal Tugas Akhir',
                'date' => '2023-01-07',
                'time' => '14:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2022/2023',
                'status' => 1,
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
                'type' => 'Seminar Proposal Tugas Akhir',
                'date' => null,
                'time' => null,
                'location_id' => null,
                'semester' => 'Genap 2022/2023',
                'status' => 0,
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
                'type' => 'Seminar Proposal Tugas Akhir',
                'date' => '2019-03-26',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Seminar Hasil Tugas Akhir',
                'date' => '2019-06-25',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Sidang Tugas Akhir',
                'date' => '2019-07-25',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Seminar Proposal Tugas Akhir',
                'date' => '2019-03-25',
                'time' => '10:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Seminar Hasil Tugas Akhir',
                'date' => '2019-06-18',
                'time' => '10:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Sidang Tugas Akhir',
                'date' => '2019-07-18',
                'time' => '10:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Seminar Proposal Tugas Akhir',
                'date' => '2019-03-26',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Genap 2018/2019',
                'status' => 2,
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
                'type' => 'Seminar Hasil Tugas Akhir',
                'date' => '2019-09-21',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Ganjil 2019/2020',
                'status' => 2,
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
                'type' => 'Sidang Tugas Akhir',
                'date' => '2019-10-21',
                'time' => '13:00:00',
                'location_id' => 1,
                'semester' => 'Ganjil 2019/2020',
                'status' => 2,
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
                $numberOfLetter = null;

                if ($seminar['status'] === 2) {
                    switch ($seminar['type']) {
                        case 'Seminar Proposal Tugas Akhir':
                            $type = 'SP';
                            break;

                        case 'Seminar Hasil Tugas Akhir':
                            $type = 'SH';
                            break;

                        default:
                            $type = 'SS';
                            break;
                    }
                    $year = Carbon::parse($seminar['validate_date'])->format('Y');
                    $month = Carbon::parse($seminar['validate_date'])->format('m');
                    switch ($month) {
                        case 1:
                            $month = 'I';
                            break;

                        case 2:
                            $month = 'II';
                            break;

                        case 3:
                            $month = 'III';
                            break;

                        case 4:
                            $month = 'IV';
                            break;

                        case 5:
                            $month = 'V';
                            break;

                        case 6:
                            $month = 'VI';
                            break;

                        case 7:
                            $month = 'VII';
                            break;

                        case 8:
                            $month = 'VIII';
                            break;

                        case 9:
                            $month = 'IX';
                            break;

                        case 10:
                            $month = 'X';
                            break;

                        case 11:
                            $month = 'XI';
                            break;

                        default:
                            $month = 'XII';
                            break;
                    }
                    $maxLength = 3;
                    $counterOfLetter = CounterOfLetter::where('type', $type)->where('year', $year)->first();
                    if ($counterOfLetter) {
                        $counterOfLetter->increment('value', 1);
                        $counterOfLetter->fresh();
                    } else {
                        $counterOfLetter = new CounterOfLetter();
                        $counterOfLetter->type = $type;
                        $counterOfLetter->year = $year;
                        $counterOfLetter->value = 1;
                        $counterOfLetter->save();
                    }
                    $number = Str::padLeft($counterOfLetter->value, $maxLength, '0');
                    $numberOfLetter = $number .'/'. $type .'/TS-S1/'. $month .'/'. $year;
                }

                $created = Seminar::create([
                    'register_date' => $seminar['register_date'],
                    'thesis_id' => $seminar['thesis_id'],
                    'type' => $seminar['type'],
                    'date' => $seminar['date'],
                    'time' => $seminar['time'],
                    'location_id' => $seminar['location_id'],
                    'semester' => $seminar['semester'],
                    'status' => $seminar['status'],
                    'validate_date' => $seminar['validate_date'],
                    'number_of_letter' => $numberOfLetter
                ]);

                $created->lecturers()->sync($seminar['examiners']);

                $thesis = Thesis::find($seminar['thesis_id']);

                $status;

                switch ($seminar['type']) {
                    case 'Sidang Tugas Akhir':
                        $status = 3;
                        break;

                    case 'Seminar Hasil Tugas Akhir':
                        $status = 2;
                        break;

                    case 'Seminar Proposal Tugas Akhir':
                        $status = 1;
                        break;

                    default:
                        $status = 0;
                        break;
                }

                $thesis->update([
                    'status' => $status
                ]);

                if ($seminar['type'] == 'Sidang Tugas Akhir') {
                    $created->chiefOfExaminer()->create([
                        'lecturer_id' => $seminar['chief_of_examiner']
                    ]);
                    $thesis->update([
                        'finish_date' => $seminar['date']
                    ]);
                    $thesis->student->update([
                        'status' => 1,
                        'graduate_date' => Carbon::parse($seminar['date'])->addDays(7)
                    ]);
                }
            });
        }
    }
}
