<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Writing Articles'],
            ['name' => 'Data Entry'],
            ['name' => 'Graphic Design'],
            ['name' => 'Web Development'],
            ['name' => 'Marketing'],
            ['name' => 'Research'],
            ['name' => 'Translation'],
            ['name' => 'Content Editing'],
            ['name' => 'Event Planning'],
            ['name' => 'Video Editing'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
