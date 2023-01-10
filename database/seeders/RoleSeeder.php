<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = collect([
            "Administrator",
            "Coordinator",
            "Head of Department"
        ]);

        $roles->each( function ($item) {
            Role::create([
                'name' => $item
            ]);
        });
    }
}
