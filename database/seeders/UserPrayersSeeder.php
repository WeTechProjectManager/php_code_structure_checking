<?php

namespace Database\Seeders;

use App\Models\UserPrayers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPrayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPrayers::create([
            'prayers' => 'Regular',
        ]);
        UserPrayers::create([
            'prayers' => 'Occasional',
        ]);
    }
}
