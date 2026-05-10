<?php

namespace Database\Seeders;

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
            ['name' => 'Skin Care', 'slug' => 'skin-care', 'image' => 'images/skin/s1.jpg'],
            ['name' => 'Eyes', 'slug' => 'eyes', 'image' => 'images/eye/e1.jpg'],
            ['name' => 'Lips', 'slug' => 'lips', 'image' => 'images/lip/l1.jpg'],
            ['name' => 'Nails', 'slug' => 'nails', 'image' => 'images/nails/n1.jpg'],
            ['name' => 'Hair', 'slug' => 'hair', 'image' => 'images/hair/h1.jpg'],
            ['name' => 'Perfume', 'slug' => 'perfume', 'image' => 'images/perfume/p1.jpg'],
            ['name' => 'Tools', 'slug' => 'tools', 'image' => 'images/tools/t1.jpg'],
            ['name' => 'Special Treatments', 'slug' => 'special-treatments', 'image' => 'images/special/sp1.jpg'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
