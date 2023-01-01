<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FieldSeeder::class,
            LocationSeeder::class,
            LecturerSeeder::class,
            ThesisSeeder::class,
            SeminarSeeder::class
        ]);
    }
}
