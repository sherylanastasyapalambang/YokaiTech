<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin1',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'address' => null,
                'phone' => null,
                'profileImage' => 'profile/profile1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarada Suki',
                'email' => 'seller1@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'seller',
                'address' => 'st. sarada sarada, sarada tomato, sarada',
                'phone' => '081234567890',
                'profileImage' => 'profile/profile2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DenkiMan',
                'email' => 'denkiman@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'seller',
                'address' => 'st. suitchi no houga saiko, Tokyo, Japan',
                'phone' => '08123456789',
                'profileImage' => 'profile/profile4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Wizzard Cat',
                'email' => 'meow@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'seller',
                'address' => 'st. meowmeow, meowcity, meowcountry',
                'phone' => '081234567890',
                'profileImage' => 'profile/profile6.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gojou Satoru',
                'email' => 'yomama@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'seller',
                'address' => 'st. shibuya, japan',
                'phone' => '081234567890',
                'profileImage' => 'profile/profile5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'I luv whiskas',
                'email' => 'whiskas@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'buyer',
                'address' => 'st. whiskas',
                'phone' => '081234567890',
                'profileImage' => 'profile/default-profileImage.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'baddas cat',
                'email' => 'badcat@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'buyer',
                'address' => 'st. baddas',
                'phone' => '081234567890',
                'profileImage' => 'profile/default-profileImage.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meowmen Sukuna',
                'email' => 'yubiyubi@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'buyer',
                'address' => 'st. shbuya, japan',
                'phone' => '081234567890',
                'profileImage' => 'profile/default-profileImage.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muki Muki Matcho',
                'email' => 'ichiban@gmai.com',
                'password' => Hash::make('12345678'),
                'role' => 'seller',
                'address' => 'st. muki, mukimuki, mukimachi',
                'phone' => '081234567890',
                'profileImage' => 'profile/profile7.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Buta Desu',
                'email' => 'buyer1@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'buyer',
                'address' => 'st. bhiiii',
                'phone' => '081234567890',
                'profileImage' => 'profile/default-profileImage.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Awkward Cat',
                'email' => 'awcat@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'buyer',
                'address' => 'st. blablabla',
                'phone' => '081234567890',
                'profileImage' => 'profile/default-profileImage.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
