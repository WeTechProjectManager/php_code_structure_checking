<?php

namespace Database\Seeders;

use App\Models\UserKnowledgeOfQuran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserKnowledgeOfQuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserKnowledgeOfQuran::create([
            'knowledgeOfQuran' => 'Low',
        ]);
        UserKnowledgeOfQuran::create([
            'knowledgeOfQuran' => 'Medium',
        ]);
        UserKnowledgeOfQuran::create([
            'knowledgeOfQuran' => 'High',
        ]);
        UserKnowledgeOfQuran::create([
            'knowledgeOfQuran' => 'Others',
        ]);
    }
}
