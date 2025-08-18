<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sections')->insert([
            [
                'name' => 'TK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SMP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SMK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
