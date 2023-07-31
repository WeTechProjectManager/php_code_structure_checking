<?php

namespace Database\Seeders;

use App\Models\UserUmrahHajj;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserUmrahHajjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserUmrahHajj::create([
            'umrahHajj' => 'Yes',
        ]);
        UserUmrahHajj::create([
            'umrahHajj' => 'No',
        ]);
    }
}
