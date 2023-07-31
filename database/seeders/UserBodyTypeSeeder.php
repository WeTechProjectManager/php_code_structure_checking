<?php

namespace Database\Seeders;

use App\Models\UserBodyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBodyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserBodyType::create([
            'type' => 'Slim',
        ]);
        UserBodyType::create([
            'type' => 'Average',
        ]);
        UserBodyType::create([
            'type' => 'Athletic',
        ]);
        UserBodyType::create([
            'type' => 'Others',
        ]);
    }
}
