<?php

namespace Database\Seeders;

use App\Models\Brand;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $faker=Factory::create();
       for ($i=0; $i< 20; $i ++){
        Brand::create([
            'name'=>$faker->word,
        ]);
       }
       
    }
}
