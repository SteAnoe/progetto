<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Sponsorship;
use Illuminate\Support\Str;
class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = [
         [
            'Level'=> 'Silver',
            'Description' => 'Entry level sponsorship',
            'Price' => '2.99',
            'Duration' => '24',
         ],
         [
            'Level'=> 'Gold',
            'Description' => 'Medium level sponsorship',
            'Price' => '5.99',
            'Duration' => '72',
         ],
         [
            'Level'=> 'Platinum',
            'Description' => 'High level sponsorship',
            'Price' => '9.99',
            'Duration' => '144',
         ],

        ];




        foreach($sponsorships as $sponsorship){
            $newSponsorship = new Sponsorship();
            $newSponsorship -> level = $sponsorship['Level'];
            $newSponsorship -> description = $sponsorship['Description'];
            $newSponsorship -> price = $sponsorship['Price'];
            $newSponsorship -> duration = $sponsorship['Duration'];
            $newSponsorship ->slug = Str::slug($newSponsorship->level);
            $newSponsorship -> save();
        }
    }
}