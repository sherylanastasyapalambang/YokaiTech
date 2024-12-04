<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'PC',
                'slug' => Str::slug('PC'),
                'description' => 'Discover a wide range of personal computers for work, study, and entertainment. Choose from desktops that deliver powerful performance tailored to your needs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop',
                'slug' => Str::slug('Laptop'),
                'description' => 'Explore versatile laptops designed for productivity and portability. Perfect for professionals, students, and gamers alike.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming',
                'slug' => Str::slug('Gaming'),
                'description' => 'Level up your gaming experience with top-tier gaming PCs, consoles, accessories, and gear built for high performance and immersion.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitors & Televisions',
                'slug' => Str::slug('Monitors & Televisions'),
                'description' => 'Enhance your viewing experience with high-resolution monitors and smart televisions. Perfect for gaming, work, or home entertainment.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PC Components',
                'slug' => Str::slug('PC Components'),
                'description' => 'Build or upgrade your PC with high-quality components, including processors, graphics cards, motherboards, and more.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PC Accessories',
                'slug' => Str::slug('PC Accessories'),
                'description' => 'Find essential PC accessories such as keyboards, mice, headsets, and more to boost your productivity and gaming experience.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smartphone',
                'slug' => Str::slug('Smartphone'),
                'description' => 'Shop the latest smartphones with cutting-edge features, designed to keep you connected and entertained.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phone Accessories',
                'slug' => Str::slug('Phone Accessories'),
                'description' => 'Enhance your smartphone experience with accessories like cases, chargers, earphones, and screen protectors.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cameras',
                'slug' => Str::slug('Cameras'),
                'description' => 'Capture life’s moments with top-quality cameras and photography equipment, from DSLRs to compact cameras.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
