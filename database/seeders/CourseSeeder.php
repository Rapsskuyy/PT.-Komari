<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Matematika',
                'price' => 300000,
                'description' => 'Bimbingan Matematika semua jenjang.',
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Inggris',
                'price' => 350000,
                'description' => 'Kursus speaking & grammar.',
                'is_active' => true,
            ],
            [
                'name' => 'IPA',
                'price' => 320000,
                'description' => 'Pendalaman materi IPA.',
                'is_active' => true,
            ],
            [
                'name' => 'IPS',
                'price' => 280000,
                'description' => 'Pendalaman materi IPS.',
                'is_active' => true,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
