<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Lecturer;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lecturers = array(
            0 => array(
                'id' => 196708171995121001,
                'name' => 'Ir. Agus Ika Putra, M.Phil',
                'nip' => '19670817 199512 1 001',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 5, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 1, 'status' => 'Pilihan'),
                )
            ),
            1 => array(
                'id' => 197308301999031001,
                'name' => 'Dr. Alex Kurniawandy, ST., MT',
                'nip' => '19730830 199903 1 001',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 4, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 1, 'status' => 'Pilihan'),
                    2 => array('lecturerable_id' => 5, 'status' => 'Pilihan'),
                )
            ),
            2 => array(
                'id' => 196806251995121001,
                'name' => 'Ir. Alfian Kamaldi, MT',
                'nip' => '19680625 199512 1 001',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 4, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 1, 'status' => 'Pilihan'),
                    2 => array('lecturerable_id' => 2, 'status' => 'Pilihan'),
                )
            ),
            3 => array(
                'id' => 196907171998031002,
                'name' => 'Andy Hendri, ST., MT',
                'nip' => '19690717 199803 1 002',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 2, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 1, 'status' => 'Pilihan'),
                    2 => array('lecturerable_id' => 5, 'status' => 'Pilihan'),
                )
            ),
            4 => array(
                'id' => 196801271995121001,
                'name' => 'Prof. Dr. Ir. Ari Sandhyavitri, M.Sc',
                'nip' => '19680127 199512 1 001',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 3, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 5, 'status' => 'Pilihan'),
                    2 => array('lecturerable_id' => 2, 'status' => 'Pilihan'),
                )
            ),
            5 => array(
                'id' => 196804131998031002,
                'name' => 'Bambang Sujatmoko, ST., MT',
                'nip' => '19680413 199803 1 002',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 2, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 1, 'status' => 'Pilihan'),
                    2 => array('lecturerable_id' => 4, 'status' => 'Pilihan'),
                )
            ),
            6 => array(
                'id' => 198905012019031000,
                'name' => 'Benny Hamdy Roma. ST.,MT.',
                'nip' => '19890501 201903 1 000',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 5, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 2, 'status' => 'Pilihan'),
                )
            ),
            7 => array(
                'id' => 199104052019031000,
                'name' => 'Edi Yusuf Adiman. ST.,M.Sc',
                'nip' => '19910405 201903 1 000',
                'major' => 'S1 Sipil',
                'status' => 'Dosen LB',
                'fields' => array(
                    0 => array('lecturerable_id' => 5, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 2, 'status' => 'Pilihan'),
                )
            ),
            8 => array(
                'id' => 196505171992031004,
                'name' => 'Ir. Enno Yuniarto, MT',
                'nip' => '19650517 199203 1 004',
                'major' => 'S1 Sipil',
                'status' => 'Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 4, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 5, 'status' => 'Pilihan'),
                    2 => array('lecturerable_id' => 1, 'status' => 'Pilihan'),
                )
            ),
            9 => array(
                'id' => 196407101995121001,
                'name' => 'Dr. Ir. Ferry Fatnanta, MT',
                'nip' => '19640710 199512 1 001',
                'major' => 'S1 Sipil',
                'status' => 'Non Aktif',
                'fields' => array(
                    0 => array('lecturerable_id' => 1, 'status' => 'Utama'),
                    1 => array('lecturerable_id' => 3, 'status' => 'Pilihan'),
                    3 => array('lecturerable_id' => 2, 'status' => 'Pilihan'),

                )
            ),
        );

        foreach ($lecturers as $lecturer) {
            DB::transaction(function() use($lecturer) {
                $created = Lecturer::create([
                    'id' => $lecturer['id'],
                    'name' => $lecturer['name'],
                    'nip' => $lecturer['nip'],
                    'major' => $lecturer['major'],
                    'status' => $lecturer['status']
                ]);

                $created->fields()->sync($lecturer['fields']);
            });
        }
    }
}
