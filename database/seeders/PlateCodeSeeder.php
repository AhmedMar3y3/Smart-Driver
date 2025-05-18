<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlateCode;

class PlateCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emirates = \App\Models\Emirate::all();

        foreach ($emirates as $emirate) {
            if ($emirate->id == 1) { // Abu Dhabi
                $codes = array_map('strval', array_merge(range(1, 21), [50]));
            } elseif ($emirate->id == 2) { // Dubai
                $codes = array_merge(range('A', 'Z'), ['AA', 'BB', 'CC', 'DD']);
            } elseif ($emirate->id == 3) { // Sharjah
                $codes = ['1', '2', '3', '4'];
            } else { // Other emirates
                $codes = range('A', 'Z');
            }

            foreach ($codes as $code) {
                PlateCode::create([
                    'emirate_id' => $emirate->id,
                    'code' => $code,
                ]);
            }
        }
    }
}
