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
            'Fiction',
            'Non-Fiction',
            'Science Fiction',
            'Fantasy',
            'Mystery',
            'Thriller',
            'Romance',
            'Biography',
            'History',
            'Science',
            'Technology',
            'Computer Science',
            'Mathematics',
            'Philosophy',
            'Psychology',
            'Self-Help',
            'Business',
            'Economics',
            'Politics',
            'Religion',
            'Art',
            'Music',
            'Travel',
            'Cooking',
            'Health',
            'Children\'s Books',
            'Young Adult',
            'Comics & Graphic Novels',
            'Poetry',
            'Drama',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
