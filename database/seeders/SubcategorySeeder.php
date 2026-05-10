<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Skin Care' => [
                ['name'=>'Moisturizer','image'=>'images/skin/s1.jpg','description'=>'Hydrating moisturizers for glowing skin.'],
                ['name'=>'Sunscreen','image'=>'images/skin/s2.jpg','description'=>'Protect your skin from harmful UV rays.'],
                ['name'=>'Serum','image'=>'images/skin/s3.jpg','description'=>'Nourishing serums for a radiant complexion.'],
                ['name'=>'Cleanser','image'=>'images/skin/s4.jpg','description'=>'Gentle cleansers for daily use.'],
                ['name'=>'Toner','image'=>'images/skin/s5.jpg','description'=>'Balance and refresh your skin.'],
                ['name'=>'Face Oil','image'=>'images/skin/s6.jpg','description'=>'Natural oils for healthy skin.'],
                ['name'=>'Face Mist','image'=>'images/skin/s7.jpg','description'=>'Refresh and hydrate anytime.'],
                ['name'=>'Exfoliator','image'=>'images/skin/s8.jpg','description'=>'Remove dead skin for a smooth touch.'],
            ],
            'Eyes' => [
                ['name'=>'Eyeliner','image'=>'images/eye/e1.jpg','description'=>'Define your eyes with precision.'],
                ['name'=>'Mascara','image'=>'images/eye/e2.jpg','description'=>'Volumize and lengthen lashes.'],
                ['name'=>'Eye Shadow','image'=>'images/eye/e3.jpg','description'=>'Vibrant shades for every occasion.'],
                ['name'=>'Eyebrow Pencil','image'=>'images/eye/e4.jpg','description'=>'Perfect brows made easy.'],
                ['name'=>'Eye Cream','image'=>'images/eye/e5.jpg','description'=>'Nourish delicate under-eye skin.'],
                ['name'=>'Eye Gel','image'=>'images/eye/e6.jpg','description'=>'Cool and refresh tired eyes.'],
                ['name'=>'Eyelash Serum','image'=>'images/eye/e7.jpg','description'=>'Strengthen and grow lashes.'],
                ['name'=>'Eye Primer','image'=>'images/eye/e8.jpg','description'=>'Long-lasting eye makeup base.'],
            ],
            'Lips' => [
                ['name'=>'Lipstick','image'=>'images/lip/l1.jpg','description'=>'Rich color for every mood.'],
                ['name'=>'Lip Gloss','image'=>'images/lip/l2.jpg','description'=>'Shiny and smooth finish.'],
                ['name'=>'Lip Balm','image'=>'images/lip/l3.jpg','description'=>'Moisturize and protect lips.'],
                ['name'=>'Lip Liner','image'=>'images/lip/l4.jpg','description'=>'Define lips precisely.'],
                ['name'=>'Lip Stain','image'=>'images/lip/l5.jpg','description'=>'Long-lasting color for lips.'],
                ['name'=>'Lip Scrub','image'=>'images/lip/l6.jpg','description'=>'Exfoliate and soften lips.'],
                ['name'=>'Lip Primer','image'=>'images/lip/l7.jpg','description'=>'Smooth base for lipstick.'],
                ['name'=>'Lip Plumper','image'=>'images/lip/l8.jpg','description'=>'Enhance lip fullness.'],
            ],
            'Nails' => [
                ['name'=>'Nail Polish','image'=>'images/nails/n1.jpg','description'=>'Vibrant nail colors.'],
                ['name'=>'Nail Care','image'=>'images/nails/n2.jpg','description'=>'Strengthen and nourish nails.'],
                ['name'=>'Nail Tools','image'=>'images/nails/n3.jpg','description'=>'Essential tools for nail care.'],
                ['name'=>'Nail Art','image'=>'images/nails/n4.jpg','description'=>'Creative designs for nails.'],
                ['name'=>'Cuticle Oil','image'=>'images/nails/n5.jpg','description'=>'Moisturize cuticles and nails.'],
                ['name'=>'Nail Strengthener','image'=>'images/nails/n6.jpg','description'=>'Prevent breakage and split nails.'],
                ['name'=>'Base Coat','image'=>'images/nails/n7.jpg','description'=>'Protect nails and enhance polish.'],
                ['name'=>'Top Coat','image'=>'images/nails/n8.jpg','description'=>'Shine and longevity for polish.'],
            ],
            'Hair' => [
                ['name'=>'Shampoo','image'=>'images/hair/h1.jpg','description'=>'Cleanse and refresh hair.'],
                ['name'=>'Conditioner','image'=>'images/hair/h2.jpg','description'=>'Smooth and detangle hair.'],
                ['name'=>'Hair Oil','image'=>'images/hair/h3.jpg','description'=>'Nourish scalp and hair.'],
                ['name'=>'Hair Serum','image'=>'images/hair/h4.jpg','description'=>'Shine and frizz control.'],
                ['name'=>'Hair Mask','image'=>'images/hair/h5.jpg','description'=>'Deep conditioning for hair.'],
                ['name'=>'Hair Spray','image'=>'images/hair/h6.jpg','description'=>'Hold style and volume.'],
                ['name'=>'Hair Mousse','image'=>'images/hair/h7.jpg','description'=>'Add volume and texture.'],
                ['name'=>'Hair Gel','image'=>'images/hair/h8.jpg','description'=>'Strong hold and styling.'],
            ],
            'Perfume' => [
                ['name'=>'Eau de Parfum','image'=>'images/perfume/p1.jpg','description'=>'Long-lasting fragrance.'],
                ['name'=>'Eau de Toilette','image'=>'images/perfume/p2.jpg','description'=>'Light and fresh scent.'],
                ['name'=>'Body Mist','image'=>'images/perfume/p3.jpg','description'=>'Refreshing all-day scent.'],
                ['name'=>'Roll-on','image'=>'images/perfume/p4.jpg','description'=>'Easy application perfume.'],
                ['name'=>'Perfume Oil','image'=>'images/perfume/p5.jpg','description'=>'Concentrated fragrance.'],
                ['name'=>'Attar','image'=>'images/perfume/p6.jpg','description'=>'Traditional natural fragrance.'],
                ['name'=>'Solid Perfume','image'=>'images/perfume/p7.jpg','description'=>'Portable and long-lasting scent.'],
                ['name'=>'Scented Candle','image'=>'images/perfume/p8.jpg','description'=>'Aromatic experience at home.'],
            ],
            'Tools' => [
                ['name'=>'Brushes','image'=>'images/tools/t1.jpg','description'=>'Professional makeup brushes.'],
                ['name'=>'Applicators','image'=>'images/tools/t2.jpg','description'=>'Easy makeup application.'],
                ['name'=>'Sponges','image'=>'images/tools/t3.jpg','description'=>'Blend makeup perfectly.'],
                ['name'=>'Tweezers','image'=>'images/tools/t4.jpg','description'=>'Precision grooming tools.'],
                ['name'=>'Eyelash Curler','image'=>'images/tools/t5.jpg','description'=>'Lift and curl lashes.'],
                ['name'=>'Makeup Bag','image'=>'images/tools/t6.jpg','description'=>'Carry all your essentials.'],
                ['name'=>'Brush Cleaner','image'=>'images/tools/t7.jpg','description'=>'Keep brushes hygienic.'],
                ['name'=>'Blending Brush','image'=>'images/tools/t8.jpg','description'=>'Smooth and perfect blending.'],
            ],
            'Special Treatments' => [
                ['name'=>'Face Masks','image'=>'images/special/sp1.jpg','description'=>'Revitalize your skin.'],
                ['name'=>'Scrubs','image'=>'images/special/sp2.jpg','description'=>'Exfoliate and smooth skin.'],
                ['name'=>'Serums','image'=>'images/special/sp3.jpg','description'=>'Target specific skin concerns.'],
                ['name'=>'Peels','image'=>'images/special/sp4.jpg','description'=>'Reveal fresh skin layers.'],
                ['name'=>'Anti-Aging','image'=>'images/special/sp5.jpg','description'=>'Reduce signs of aging.'],
                ['name'=>'Brightening','image'=>'images/special/sp6.jpg','description'=>'Enhance skin radiance.'],
                ['name'=>'Detox','image'=>'images/special/sp7.jpg','description'=>'Cleanse and rejuvenate skin.'],
                ['name'=>'Hydrating','image'=>'images/special/sp8.jpg','description'=>'Deep hydration for skin.'],
            ],
        ];

        foreach ($data as $catName => $subcats) {
            $category = Category::where('name', $catName)->first();
            if (!$category) continue;

            foreach ($subcats as $sub) {
                Subcategory::create([
                    'name' => $sub['name'],
                    'slug' => strtolower(str_replace(' ','-',$sub['name'])),
                    'image' => $sub['image'],
                    'description' => $sub['description'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
