<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thesis;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ThesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theses = [
            [
                'student' => [
                    'name' => 'Nelson Yuli Chandra',
                    'nim' => '1507113091',
                    'phone' => '082169982041',
                    'gpa' => 3.14
                ],
                'thesis' => [
                    'register_date' => '2022-09-10',
                    'title' => 'Analisis Kelayakan Finansial Pembangunan Gedung Parkir Sukaramai Trade Center II',
                    'field_id' => 1,
                    'supervisors' => [
                        [
                            'lecturer_id' => 1,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 3,
                            'status' => 'Pembimbing 2'
                        ],
                    ],
                    'semester' => 'Genap 2022/2023'
                ]
            ],
            [
                'student' => [
                    'name' => 'David Imannuel',
                    'nim' => '1307114726',
                    'phone' => '085373920424',
                    'gpa' => 3.34
                ],
                'thesis' => [
                    'register_date' => '2022-09-20',
                    'title' => 'Analisis Hidrologi Model Soil Moisture Accounting dengan Metode Kalibrasi Root Mean Square Error',
                    'field_id' => 2,
                    'supervisors' => [
                        [
                            'lecturer_id' => 2,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 6,
                            'status' => 'Pembimbing 2'
                        ],
                    ],
                    'semester' => 'Genap 2022/2023'
                ]
            ],
            [
                'student' => [
                    'name' => 'Harpian Surya',
                    'nim' => '1507117600',
                    'phone' => '085375656275',
                    'gpa' => 3.00
                ],
                'thesis' => [
                    'register_date' => '2019-01-28',
                    'title' => 'Pengaruh Air Gambut terhadap Lapisan Asphalt Concrete – Wearing Course (AC-WC)',
                    'field_id' => 5,
                    'supervisors' => [
                        [
                            'lecturer_id' => 1,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 2,
                            'status' => 'Pembimbing 2'
                        ]
                    ],
                    'semester' => 'Genap 2018/2019'
                ]
            ],
            [
                'student' => [
                    'name' => 'Fajar Priandoko',
                    'nim' => '1507123551',
                    'phone' => '081374454684',
                    'gpa' => 3.10
                ],
                'thesis' => [
                    'register_date' => '2019-03-20',
                    'title' => 'Pengaruh Variasi Volume Konsentrasi Bakteri Bacillus Subtilis Terhadap Sifat Fisik Beton',
                    'field_id' => 4,
                    'supervisors' => [
                        [
                            'lecturer_id' => 2,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 3,
                            'status' => 'Pembimbing 2'
                        ]
                    ],
                    'semester' => 'Genap 2018/2019'
                ]
            ],
            [
                'student' => [
                    'name' => 'Muhammad Randy Alfath',
                    'nim' => '1507112756',
                    'phone' => '085376877156',
                    'gpa' => 3.10
                ],
                'thesis' => [
                    'register_date' => '2019-01-29',
                    'title' => 'Pengaruh Penyekat Kanal Terhadap Pembasahan Lahan Gambut Studi Kasus di Desa Dompas Kecamatan Bukit Batu Kabupaten Bengkalis ',
                    'field_id' => 2,
                    'supervisors' => [
                        [
                            'lecturer_id' => 3,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 4,
                            'status' => 'Pembimbing 2'
                        ]
                    ],
                    'semester' => 'Genap 2018/2019'
                ]
            ],
            [
                'student' => [
                    'name' => 'Bagus Muhammad Akbar',
                    'nim' => '1707165913',
                    'phone' => '085278739363',
                    'gpa' => 2.90
                ],
                'thesis' => [
                    'register_date' => '2019-02-04',
                    'title' => 'Analisis Overlay Metode Bina Marga 2017 dan Deflectometry Pada Jalan SM Amin Kota Pekanbaru',
                    'field_id' => 5,
                    'supervisors' => [
                        [
                            'lecturer_id' => 5,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 6,
                            'status' => 'Pembimbing 2'
                        ]
                    ],
                    'semester' => 'Genap 2018/2019'
                ]
            ],
            [
                'student' => [
                    'name' => 'M. Nurul',
                    'nim' => '1707165945',
                    'phone' => '081137858575',
                    'gpa' => 3.13
                ],
                'thesis' => [
                    'register_date' => '2019-02-04',
                    'title' => 'Analisis Perbandingan Metode PD T-05-2005-B Dan Pedoman MDPJ No. 04/SE/DB/2017 dalam Perencanaan (Overlay) pada Jalan SM Amin Pekanbaru',
                    'field_id' => 5,
                    'supervisors' => [
                        [
                            'lecturer_id' => 7,
                            'status' => 'Pembimbing 1'
                        ],
                        [
                            'lecturer_id' => 8,
                            'status' => 'Pembimbing 2'
                        ]
                    ],
                    'semester' => 'Genap 2018/2019'
                ]
            ],
        ];

        foreach ($theses as $thesis) {
            DB::transaction(function() use($thesis) {
                $student = Student::create([
                    'name' => $thesis['student']['name'],
                    'nim' => $thesis['student']['nim'],
                    'phone' => $thesis['student']['phone'],
                    'register_date' => Str::padLeft(Str::substr($thesis['student']['nim'], 0, 2), 4, '20'). '-' .Str::substr($thesis['student']['nim'], 2, 2). '-01',
                    'generation' => Str::padLeft(Str::substr($thesis['student']['nim'], 0, 2), 4, '20'),
                    'gpa' => $thesis['student']['gpa']
                ]);

                $created = Thesis::create([
                    'student_id' => $student->id,
                    'register_date' => $thesis['thesis']['register_date'],
                    'title' => $thesis['thesis']['title'],
                    'field_id' => $thesis['thesis']['field_id'],
                    'semester' => $thesis['thesis']['semester']
                ]);

                $created->lecturers()->sync($thesis['thesis']['supervisors']);
            });
        }
    }
}
