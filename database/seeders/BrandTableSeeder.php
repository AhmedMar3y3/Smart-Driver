<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'KIA'],
            ['name' => 'Honda'],
            ['name' => 'Ford'],
            ['name' => 'Chevrolet'],
            ['name' => 'Nissan'],
            ['name' => 'BMW'],
            ['name' => 'Mercedes'],
            ['name' => 'Volkswagen'],
            ['name' => 'Audi'],
            ['name' => 'Hyundai'],
        ];

        DB::table('brands')->insert($brands);
    }
}
