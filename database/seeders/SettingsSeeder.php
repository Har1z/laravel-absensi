<?php

namespace Database\Seeders;

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
        DB::table('settings')->insert([
            [
                'unit' => 'TK',
                'in_message' => 'Pesan Hadir TK',
                'out_message' => 'Pesan Pulang TK',
                'present_time' => '07:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit' => 'SD',
                'in_message' => 'Pesan Hadir SD',
                'out_message' => 'Pesan Pulang SD',
                'present_time' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit' => 'SMP',
                'in_message' => 'Pesan Hadir SMP',
                'out_message' => 'Pesan Pulang SMP',
                'present_time' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit' => 'SMK',
                'in_message' => 'Pesan Hadir SMK',
                'out_message' => 'Pesan Pulang SMK',
                'present_time' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
