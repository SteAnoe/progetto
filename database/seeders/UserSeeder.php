<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Admin\Doctor;
use App\Models\Admin\Specialization;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        $specializations = Specialization::all();
        
        for($i = 1; $i <= 100; $i++) {
            $newUser = new User();
            $newUser->name = $faker->unique()->firstName;
            $newUser->lastname = $faker->unique()->lastName;
            $newUser->email = $faker->unique()->email;
            $newUser->password = Hash::make('password');
            $newUser->address = $faker->unique()->address;
            $newUser->slug = Str::slug($newUser->name .'-'. $newUser->lastname);
            $newUser->save();

            $newDoctor = new Doctor();
            $newDoctor->user_id = $newUser->id;
            $newDoctor->phone = $faker->numerify('##########');
            $newDoctor->curriculum_vitae = 'curriculm.jpeg';
            $newDoctor->photo = 'doctor-login.png';
            $newDoctor->description = $faker->paragraph;
            $newDoctor->save();
        
            

            $numSpecializations = $faker->numberBetween(1, 2);

            $randomSpecializations = $specializations->random($numSpecializations);
            $newDoctor->specializations()->attach($randomSpecializations);
    }
}
}