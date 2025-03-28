<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmiratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emirates = [
            ['name' => 'أبو ظبي'],
            ['name' => 'دبي'],
            ['name' => 'الشارقة'],
            ['name' => 'عجمان'],
            ['name' => 'أم القيوين'],
            ['name' => 'الفجيرة'],
            ['name' => 'رأس الخيمة'],
        ];
        DB::table('emirates')->insert($emirates);
    }
}
