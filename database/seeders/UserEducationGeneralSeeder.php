<?php

namespace Database\Seeders;

use App\Models\UserEducationGeneral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserEducationGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserEducationGeneral::create([
            'education' => 'Primary',
        ]);
        UserEducationGeneral::create([
            'education' => 'JSC',
        ]);
        UserEducationGeneral::create([
            'education' => 'HSC',
        ]);
        UserEducationGeneral::create([
            'education' => 'Primary',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Business Administration',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Information Technology',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Nursing',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Hospitality Management',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Electrical Engineering',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Early Childhood Education',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Culinary Arts',
        ]);
        UserEducationGeneral::create([
            'education' => 'Bachelor of Engineering (B.Eng.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Bachelor of Science in Engineering (B.S.E.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Bachelor of Technology (B.Tech.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Bachelor of Applied Science (B.A.Sc.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Master of Engineering (M.Eng.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Master of Science in Engineering (M.S.E.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Master of Technology (M.Tech.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Primary',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Philosophy in Engineering (Ph.D. in Engineering)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Diploma in Fashion Design',
        ]);
        UserEducationGeneral::create([
            'education' => 'Bachelor of Medicine, Bachelor of Surgery (MBBS)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Osteopathic Medicine (D.O.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Dental Surgery (DDS)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Dental Medicine (DMD)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Pharmacy (Pharm.D.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Optometry (O.D.):',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Veterinary Medicine (DVM)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Engineering (D.Eng.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Doctor of Medicine (M.D.)',
        ]);
        UserEducationGeneral::create([
            'education' => 'Others',
        ]);
    }
}
