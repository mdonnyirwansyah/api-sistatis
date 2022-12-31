<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = collect([
            "Ruang Seminar Prodi Teknik Sipil S1",
            "Ruang Seminar Lab. Struktur",
            "Ruang Seminar Lab. Hidroteknik",
            "Ruang Kelas Prodi S1 Teknik Sipil",
            "Ruang Seminar Lab. Mekanika Tanah",
            "Daring (Zoom)"
        ]);

        $locations->each( function ($item) {
            Location::create([
                'name' => $item
            ]);
        });
    }
}
