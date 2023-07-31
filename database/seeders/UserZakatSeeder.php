<?php

namespace Database\Seeders;

use App\Models\UserZakat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserZakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserZakat::create([
            'zakat' => 'Yes',
        ]);
        UserZakat::create([
            'zakat' => 'No',
        ]);
    }
}
