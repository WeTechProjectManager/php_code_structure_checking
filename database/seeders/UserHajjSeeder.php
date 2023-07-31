<?php

namespace Database\Seeders;

use App\Models\UserHajj;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHajjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserHajj::create([
            'hajj' => 'Yes',
        ]);
        UserHajj::create([
            'hajj' => 'No',
        ]);
    }
}
