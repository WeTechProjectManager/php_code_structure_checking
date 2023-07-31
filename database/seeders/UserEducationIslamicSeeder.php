<?php

namespace Database\Seeders;

use App\Models\UserEducationIslamic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserEducationIslamicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserEducationIslamic::create([
            'education' => 'JDC',
        ]);
        UserEducationIslamic::create([
            'education' => 'Dakhil',
        ]);
        UserEducationIslamic::create([
            'education' => 'Alim',
        ]);
        UserEducationIslamic::create([
            'education' => 'Fagil',
        ]);
        UserEducationIslamic::create([
            'education' => 'Hafiz / Hafiza',
        ]);
        UserEducationIslamic::create([
            'education' => 'Dawra Hadith ',
        ]);
        UserEducationIslamic::create([
            'education' => 'Mufti',
        ]);
    }
}
