<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('orders')->insert([
                'status' => $faker->randomElement(['Pending', 'Delivered', 'Out for deliver', 'Canceled', 'Accepted']),
                'user_id' => $faker->randomNumber(1,20), 
                'location_id' => $faker->randomNumber(5,20),
                'total' => $faker->randomFloat(2, 50, 500),
                'date_of_deliver' => $faker->date('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
