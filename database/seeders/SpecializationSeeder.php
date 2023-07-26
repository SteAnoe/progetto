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
            [
                'namespec' => 'Medicina-Interna',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_genetica-100x100-1.png'   
            ],
            [
                'namespec' => 'Chirurgia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_chirurgia-generale-100x100-1.png'   
            ],
            [
                'namespec' => 'Radiologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_radiologia-31-100x100-1.png'   
            ],
            [
                'namespec' => 'Oncologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icona_oncologia-100x100-1.jpeg'   
            ],
            [
                'namespec' => 'Dermatologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/01/icone_dermatologia-100x100-1.png'   
            ],
            [
                'namespec' => 'Urologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_urologia-100x100-1.png'   
            ],
            [
                'namespec' => 'Ematologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icona_ematologia-100x100-1.jpg'   
            ],
            [
                'namespec' => 'Endocrinologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_endocrinologia-100x100-1.png'   
            ],
            [
                'namespec' => 'Nefrologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_nefrologia-100x100-1.png'   
            ],
            [
                'namespec' => 'Ortopedia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_ortopedia-100x100-1.png'   
            ],
            [
                'namespec' => 'Gastroentrologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/01/icone_gastroenterologia-100x100-1.png'   
            ],
            [
                'namespec' => 'Psichiatria',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_psichiatria-100x100-1.png'   
            ],
            [
                'namespec' => 'Pediatria',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_pediatria-100x100-1.png'   
            ],
            [
                'namespec' => 'Oculistica',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/01/icone_oculistica-100x100-1.png'   
            ],
            [
                'namespec' => 'Ginecologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_ginecologia-100x100-1.png'   
            ],
            [
                'namespec' => 'Cardiologia',
                'img' => 'https://www.doctorium.it/wp-content/uploads/2022/02/icone_cardiologia-100x100-1.png'   
            ],

           
        ];
        foreach($specializations as $specialization){
            $newSpecialization = new Specialization();
            $newSpecialization -> name = $specialization['namespec'];
            $newSpecialization -> slug =Str::slug($newSpecialization->name);
            $newSpecialization -> img = $specialization['img'];
            $newSpecialization -> save();
        }
    }
}