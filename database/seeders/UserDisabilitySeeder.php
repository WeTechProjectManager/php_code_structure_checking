<?php

namespace Database\Seeders;

use App\Models\UserDisability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDisabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserDisability::create([
            'disabilities' => 'Yes',
        ]);
        UserDisability::create([
            'disabilities' => 'No',
        ]);
    }
}
