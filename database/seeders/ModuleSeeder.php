<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $modules = [
            ['name' => 'Dashboard', 'slug' => 'dashboard', 'status' => 1],
            ['name' => 'Website Frontend', 'slug' => 'website_frontend', 'status' => 1],
            // ['name' => 'Banner', 'slug' => 'banner', 'status' => 1],
            // ['name' => 'Vision', 'slug' => 'vision', 'status' => 1],
            // ['name' => 'About Us', 'slug' => 'about_us', 'status' => 1],
            // ['name' => 'Professional', 'slug' => 'professional', 'status' => 1],
            // ['name' => 'Why Choose Us', 'slug' => 'why_choose_us', 'status' => 1],
            // ['name' => 'Instructor', 'slug' => 'instructor', 'status' => 1],
            // ['name' => 'Companies', 'slug' => 'companies', 'status' => 1],
            // ['name' => 'Certificate', 'slug' => 'certificate', 'status' => 1],
            // ['name' => 'Community', 'slug' => 'community', 'status' => 1],
            // ['name' => 'Testimonial', 'slug' => 'testimonial', 'status' => 1],
            // ['name' => 'Contact', 'slug' => 'contact', 'status' => 1],
            // ['name' => 'FAQ', 'slug' => 'faq', 'status' => 1],
            ['name' => 'Categories', 'slug' => 'categories', 'status' => 1],
            ['name' => 'Student', 'slug' => 'student', 'status' => 1],
            ['name' => 'Course', 'slug' => 'course', 'status' => 1],
            ['name' => 'Classes', 'slug' => 'classes', 'status' => 1],
            ['name' => 'Faculty', 'slug' => 'faculty', 'status' => 1],
            ['name' => 'Enrollment', 'slug' => 'enrollment', 'status' => 1],
            ['name' => 'Payment', 'slug' => 'payment', 'status' => 1],
            ['name' => 'Master', 'slug' => 'master', 'status' => 1],
            ['name' => 'Quiz', 'slug' => 'quiz', 'status' => 1],
            ['name' => 'Question', 'slug' => 'question', 'status' => 1],
            ['name' => 'Batch', 'slug' => 'batch', 'status' => 1],
            ['name' => 'Attendance', 'slug' => 'attendance', 'status' => 1],
            ['name' => 'Users', 'slug' => 'users', 'status' => 1],
            ['name' => 'Assignment', 'slug' => 'assignment', 'status' => 1],
            // ['name' => 'Modules', 'slug' => 'modules', 'status' => 1],
            // ['name' => 'Profile', 'slug' => 'profile', 'status' => 1],
            ['name' => 'Permission', 'slug' => 'permission', 'status' => 1],
            ['name' => 'Exam', 'slug' => 'exam', 'status' => 1],
            ['name' => 'Classroom', 'slug' => 'classroom', 'status' => 1],
            ['name' => 'Announcement', 'slug' => 'announcement', 'status' => 1],
            ['name' => 'Study_material', 'slug' => 'study_material', 'status' => 1],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(
                ['slug' => $module['slug']],
                $module
            );
        }
    }
}
