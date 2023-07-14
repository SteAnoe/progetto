<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Message;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    { 
        for($i = 0; $i < 30; $i++){
            $newMessage =  new Message();
            $newMessage -> doctor_id = rand(1,30);
            $newMessage -> email = $faker->unique()->email;
            $newMessage -> name = $faker -> unique()->firstName;
            $newMessage -> lastname = $faker->unique()->lastName;
            $newMessage -> text = $faker ->paragraph;
            $newMessage -> slug = Str::slug($newMessage->name .'-'. $newMessage->lastname);
            $newMessage -> save();
        }
    }
}