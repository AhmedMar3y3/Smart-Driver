<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'الفئة الأولى'],
            ['name' => 'الفئة الثانية'],
            ['name' => 'الفئة الثالثة'],
            ['name' => 'الفئة الرابعة'],
            ['name' => 'الفئة الخامسة'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 