<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = collect([
            "Geo Teknik",
            "Hidro Teknik",
            "Managemen",
            "Struktur",
            "Transportasi"
        ]);

        $fields->each( function ($item) {
            Field::create([
                'name' => $item
            ]);
        });
    }
}
