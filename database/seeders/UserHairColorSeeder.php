<?php

namespace Database\Seeders;

use App\Models\UserHairColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHairColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserHairColor::create([
            'color' => 'Black',
        ]);
        UserHairColor::create([
            'color' => 'Brown',
        ]);
        UserHairColor::create([
            'color' => 'Blond',
        ]);
        UserHairColor::create([
            'color' => 'White',
        ]);
        UserHairColor::create([
            'color' => 'Gray',
        ]);
        UserHairColor::create([
            'color' => 'Rarely red',
        ]);
        UserHairColor::create([
            'color' => 'Others',
        ]);
    }
}
