<?php

namespace Database\Seeders;

use App\Models\UserEyeColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserEyeColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserEyeColor::create([
            'color' => 'Black',
        ]);
        UserEyeColor::create([
            'color' => 'Blue',
        ]);
        UserEyeColor::create([
            'color' => 'Brown',
        ]);
        UserEyeColor::create([
            'color' => 'Green',
        ]);
        UserEyeColor::create([
            'color' => 'Gray',
        ]);
        UserEyeColor::create([
            'color' => 'Hazel',
        ]);
        UserEyeColor::create([
            'color' => 'Red',
        ]);
        UserEyeColor::create([
            'color' => 'Others',
        ]);
    }
}
