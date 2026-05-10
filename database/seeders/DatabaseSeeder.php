<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Categories + Sliders
        $this->call([
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\AdminSeeder::class,
            \Database\Seeders\SubcategorySeeder::class,
            \Database\Seeders\ProductSeeder::class,
             
         
        ]);
        
    }
    
}
