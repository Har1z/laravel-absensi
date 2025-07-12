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
                'in_message' => 'In',
                'out_message' => 'Out',
                'present_time' => '07:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit' => 'SD',
                'in_message' => 'In',
                'out_message' => 'Out',
                'present_time' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit' => 'SMP',
                'in_message' => 'In',
                'out_message' => 'Out',
                'present_time' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit' => 'SMK',
                'in_message' => 'In',
                'out_message' => 'Out',
                'present_time' => '07:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
