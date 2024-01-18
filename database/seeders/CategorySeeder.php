<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Factory::create();
        
        for ($i = 0; $i < 20; $i ++){
            Category::create([
                'name'=>$faker->name,
                'image'=>$faker->imageUrl(),
            ]);
        }
    }
}
