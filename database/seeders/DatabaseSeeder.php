<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Plate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        //    BrandTableSeeder::class,
            // EmiratesTableSeeder::class,
            // CategorySeeder::class,
            // PackageSeeder::class,
            // PlateCodeSeeder::class,
            SectionSeeder::class,
        ]);
    }
}
