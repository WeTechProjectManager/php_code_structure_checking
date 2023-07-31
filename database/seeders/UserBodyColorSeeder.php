<?php

namespace Database\Seeders;

use App\Models\BodyColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBodyColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BodyColor::create([
            'color' => 'Fair or Pale',
        ]);
        BodyColor::create([
            'color' => 'Light or Light Brown',
        ]);
        BodyColor::create([
            'color' => 'Olive',
        ]);
        BodyColor::create([
            'color' => 'Medium or Medium Brown',
        ]);
        BodyColor::create([
            'color' => 'Tan',
        ]);
        BodyColor::create([
            'color' => 'Dark or Dark Brown',
        ]);
        BodyColor::create([
            'color' => 'Deep or Deep Brown',
        ]);
        BodyColor::create([
            'color' => 'Ebony or Black',
        ]);
    }
}
