<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Section;
use App\Models\UserSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SectionSeeder::class,
            SettingsSeeder::class,
        ]);

        $superAdminId = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'is_superadmin' => TRUE,
            'password' => Hash::make('acprilesma-laboratorium2025'),
        ]);

        for ($i=0; $i < 10; $i++) {
            $sections = Section::get();

            $dummyAdminId = DB::table('users')->insertGetId([
                'name' => fake()->name(),
                'email' => fake()->unique()->email(),
                'password' => Hash::make('password'),
            ]);

            foreach ($sections as $section) {
                UserSection::firstOrCreate([
                    'user_id' => $dummyAdminId,
                    'section_id' => $section->id
                ]);
            }
        }
    }
}
