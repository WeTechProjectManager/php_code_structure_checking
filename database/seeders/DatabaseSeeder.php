<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            CountrySeeder::class,
            UserHairColorSeeder::class,
            UserEyeColorSeeder::class,
            UserBodyTypeSeeder::class,
            UserDisabilitySeeder::class,
            UserPrayersSeeder::class,
            UserZakatSeeder::class,
            UserHajjSeeder::class,
            UserUmrahHajjSeeder::class,
            UserKnowledgeOfQuranSeeder::class,
            UserEducationGeneralSeeder::class,
            UserEducationIslamicSeeder::class,
            UserBodyColorSeeder::class,
        ]);
    }
}
