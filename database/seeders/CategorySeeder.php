<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Programming'],
            ['name' => 'Design'],
            ['name' => 'Business'],
            ['name' => 'Marketing'],
            ['name' => 'Personal Development'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
