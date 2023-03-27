<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thesis;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ThesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theses = array(
            0 => array(
                'student' => array(
                    'name' => 'Nelson Yuli Chandra',
                    'nim' => '1507113091',
                    'phone' => '082169982041',
                ),
                'thesis' => array(
                    'register_date' => '2022-09-10',
                    'title' => 'Analisis Kelayakan Finansial Pembangunan Gedung Parkir Sukaramai Trade Center II',
                    'field_id' => 1,
                    'supervisors' => array(
                        0 => array(
                            'lecturer_id' => 1,
                            'status' => 'Pembimbing 1'
                        ),
                        1 => array(
                            'lecturer_id' => 3,
                            'status' => 'Pembimbing 2'
                        ),
                    ),
                    'semester' => 'Genap 2022/2023'
                )
            ),
            1 => array(
                'student' => array(
                    'name' => 'David Imannuel',
                    'nim' => '1307114726',
                    'phone' => '085373920424',
                ),
                'thesis' => array(
                    'register_date' => '2022-09-20',
                    'title' => 'Analisis Hidrologi Model Soil Moisture Accounting dengan Metode Kalibrasi Root Mean Square Error',
                    'field_id' => 2,
                    'supervisors' => array(
                        0 => array(
                            'lecturer_id' => 2,
                            'status' => 'Pembimbing 1'
                        ),
                        1 => array(
                            'lecturer_id' => 6,
                            'status' => 'Pembimbing 2'
                        ),
                    ),
                    'semester' => 'Genap 2022/2023'
                )
            ),
        );

        foreach ($theses as $thesis) {
            DB::transaction(function() use($thesis) {
                $student = Student::create([
                    'name' => $thesis['student']['name'],
                    'nim' => $thesis['student']['nim'],
                    'phone' => $thesis['student']['phone'],
                    'status' => 'Tugas Akhir'
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
