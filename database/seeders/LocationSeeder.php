<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Location;
class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Factory::create();
        
        for ($i = 0; $i < 20; $i ++){
            Location::create([
                'user_id'=>1,
                'street'=>$faker->streetAddress,
                'area'=>$faker->city,
                'building'=>$faker->buildingNumber,

            ]);
        }
    }
}
