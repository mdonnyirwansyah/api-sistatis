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
                    'id' => 1507113091,
                    'name' => 'Nelson Yuli Chandra',
                    'phone' => '082169982041',
                ),
                'thesis' => array(
                    'register_date' => '2022-09-10',
                    'title' => 'Analisis Kelayakan Finansial Pembangunan Gedung Parkir Sukaramai Trade Center II',
                    'field_id' => 1,
                    'supervisors' => array(
                        0 => array(
                            'lecturer_id' => 196708171995121001,
                            'status' => 'Pembimbing 1'
                        ),
                        1 => array(
                            'lecturer_id' => 196806251995121001,
                            'status' => 'Pembimbing 2'
                        ),
                    )
                )
            ),
            1 => array(
                'student' => array(
                    'id' => 1307114726,
                    'name' => 'David Imannuel',
                    'phone' => '085373920424',
                ),
                'thesis' => array(
                    'register_date' => '2022-09-20',
                    'title' => 'Analisis Hidrologi Model Soil Moisture Accounting dengan Metode Kalibrasi Root Mean Square Error',
                    'field_id' => 2,
                    'supervisors' => array(
                        0 => array(
                            'lecturer_id' => 197308301999031001,
                            'status' => 'Pembimbing 1'
                        ),
                        1 => array(
                            'lecturer_id' => 196804131998031002,
                            'status' => 'Pembimbing 2'
                        ),
                    )
                )
            ),
        );

        foreach ($theses as $thesis) {
            DB::transaction(function() use($thesis) {
                Student::create([
                    'id' => $thesis['student']['id'],
                    'name' => $thesis['student']['name'],
                    'phone' => $thesis['student']['phone'],
                    'status' => 'Tugas Akhir'
                ]);

                $created = Thesis::create([
                    'student_id' => $thesis['student']['id'],
                    'register_date' => $thesis['thesis']['register_date'],
                    'title' => $thesis['thesis']['title'],
                    'field_id' => $thesis['thesis']['field_id']
                ]);

                $created->lecturers()->sync($thesis['thesis']['supervisors']);
            });
        }
    }
}
