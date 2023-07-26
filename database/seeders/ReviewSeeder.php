<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Review;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 90; $i++){
            $newReview =  new Review();
            $newReview -> doctor_id = rand(1,30);
            $newReview -> stars = $faker-> numberBetween(1,5);
            $newReview -> name = $faker -> unique()->firstName;
            $newReview -> lastname = $faker->unique()->lastName;
            $newReview -> text = $faker ->paragraph;
            
            $newReview -> save();
        }
    }
}