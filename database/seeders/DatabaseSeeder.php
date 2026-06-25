<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Track;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        foreach ([
            ['name' => 'Front-End', 'slug' => 'frontend', 'description' => 'HTML, CSS, JavaScript, React وواجهات الويب.'],
            ['name' => 'Back-End', 'slug' => 'backend', 'description' => 'PHP, Laravel, Node.js, APIs وقواعد البيانات.'],
            ['name' => 'Full-Stack', 'slug' => 'fullstack', 'description' => 'دمج الواجهات مع السيرفر وبناء تطبيقات كاملة.'],
            ['name' => 'Mobile Development', 'slug' => 'mobile', 'description' => 'Flutter وتطبيقات Android و iOS.'],
            ['name' => 'Network', 'slug' => 'network', 'description' => 'الشبكات والبنية التحتية وأساسيات الأمن.'],
            ['name' => 'AI & Machine Learning', 'slug' => 'ai', 'description' => 'تحليل البيانات والنماذج الذكية.'],
        ] as $track) {
            Track::firstOrCreate(['slug' => $track['slug']], $track);
        }

        Admin::updateOrCreate(
            ['email' => 'admin@academiaplus.test'],
            [
                'name' => 'Academia Plus Admin',
                'password' => bcrypt('Admin@12345'),
                'role' => 'super_admin',
                'permissions' => [
                    'view_dashboard',
                    'view_contact_messages',
                    'manage_students',
                    'manage_instructors',
                    'manage_courses',
                ],
            ]
        );
    }
}
