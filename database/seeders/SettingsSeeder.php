<?php

namespace Database\Seeders;

use App\Models\Section;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections     = Section::get()->toArray();
        $dataToInsert = [];

        foreach ($sections as $section) {
            $dataToInsert[] = [
                'section_id' => $section['id'],
                'in_message' => 'Pesan Hadir '.$section['name'],
                'out_message' => 'Pesan Pulang '.$section['name'],
                'present_time' => '07:30:00',
                'out_time' => '11:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }


        DB::table('settings')->insert($dataToInsert);
    }
}
