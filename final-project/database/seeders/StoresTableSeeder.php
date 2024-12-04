<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'seller_id' => 1,
                'slug' => Str::slug('Sarada Gaming'),
                'name' => 'Sarada Gaming',
                'description' => 'Gaming so fresh, it’s like biting into a salad! Sarada Gaming serves up the juiciest gaming gear, from consoles to accessories. Whether you’re a pro or just here for a “healthy” gaming session, it’s your perfect place to power up!',
                'address' => 'St. Gaming Boulevard, Tokyo',
                'phone' => '081234567801',
                'storeImage' => 'stores/store-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 3,
                'slug' => Str::slug('DenkiYa'),
                'name' => 'DenkiYa',
                'description' => 'For PC nerds, by a PC nerd! DenkiYa is the home for all things tech, from laptops to glowing PC parts. If you dream in binary, you’ll love it here—geek out with the best!',
                'address' => 'St. Tech Paradise, Osaka',
                'phone' => '081234567802',
                'storeImage' => 'stores/store-2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 5,
                'slug' => Str::slug('GojoBox'),
                'name' => 'GojoBox',
                'description' => 'Six Eyes-approved smartphones and accessories! Gojo Satoru’s store, where style meets power. Get your hands on the latest iPhones and accessories with a touch of limitless flair.',
                'address' => 'St. Shibuya Style, Tokyo',
                'phone' => '081234567803',
                'storeImage' => 'stores/store-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 4,
                'slug' => Str::slug('The Wizzard Galaxy'),
                'name' => 'The Wizzard Galaxy',
                'description' => 'Magical Samsung tech, brought to you by a wizard cat! Run by a wizard cat, The Wizzard Galaxy offers magical Samsung smartphones and accessories. Expect enchanted performance in every device!',
                'address' => 'St. Wizardry Lane, Meowtown',
                'phone' => '081234567804',
                'storeImage' => 'stores/store-4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 9,
                'slug' => Str::slug('MukiCAM'),
                'name' => 'MukiCAM',
                'description' => 'Cameras so strong, they’ll flex for you! Owned by a buff camera buff, MukiCAM delivers gear that helps you capture moments with power. It’s the place for pro-level photography!',
                'address' => 'St. Camera Lane, Kyoto',
                'phone' => '081234567805',
                'storeImage' => 'stores/store-5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
