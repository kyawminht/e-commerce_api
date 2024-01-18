<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'category_id' => $faker->numberBetween(1, 20), 
                'brand_id' => $faker->numberBetween(1, 20),    
                'is_trendy' => $faker->boolean,
                'is_available' => $faker->boolean,
                'price' => $faker->randomFloat(2, 10, 1000),
                'quantity' => $faker->numberBetween(1, 100),
                'discount' => $faker->randomFloat(2, 0, 50),
                'image' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
