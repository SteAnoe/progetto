<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Admin\Specialization;
class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $specializations = [
            'Medicina-Interna',
            'Chirurgia',
            'Gereatria',
            'Oncologia',
            'Dermatologia',
            'Ematologia',
            'Endocrinologia',
            'Nefrologia',
            'Psichiatria',
            'Neurologia',
            'Pediatria',
            'Ginecologia',
            'Ortopedia',
            'Radioterapia',
        ];
        foreach($specializations as $specialization){
            $newSpecialization = new Specialization();
            $newSpecialization -> name = $specialization;
            $newSpecialization -> slug =Str::slug($newSpecialization->name);
            $newSpecialization -> save();
        }
    }
}