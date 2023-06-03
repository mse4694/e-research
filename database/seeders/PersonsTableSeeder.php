<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakePersonData = '[
            {"firstName": "Terry","lastName": "Medhurst","email": "atuny0@sohu.com","username": "atuny0","image": "https://robohash.org/hicveldicta.png"},
            {"firstName": "Sheldon","lastName": "Quigley","email": "hbingley1@plala.or.jp","username": "hbingley1","image": "https://robohash.org/doloremquesintcorrupti.png"},
            {"firstName": "Terrill","lastName": "Hills","email": "rshawe2@51.la","username": "rshawe2","image": "https://robohash.org/consequunturautconsequatur.png"},
            {"firstName": "Miles","lastName": "Cummerata","email": "yraigatt3@nature.com","username": "yraigatt3","image": "https://robohash.org/facilisdignissimosdolore.png"},
            {"firstName": "Mavis","lastName": "Schultz","email": "kmeus4@upenn.edu","username": "kmeus4","image": "https://robohash.org/adverovelit.png"},
            {"firstName": "Alison","lastName": "Reichert","email": "jtreleven5@nhs.uk","username": "jtreleven5","image": "https://robohash.org/laboriosamfacilisrem.png"},
            {"firstName": "Oleta","lastName": "Abbott","email": "dpettegre6@columbia.edu","username": "dpettegre6","image": "https://robohash.org/cupiditatererumquos.png"},
            {"firstName": "Ewell","lastName": "Mueller","email": "ggude7@chron.com","username": "ggude7","image": "https://robohash.org/quiaharumsapiente.png"},
            {"firstName": "Demetrius","lastName": "Corkery","email": "nloiterton8@aol.com","username": "nloiterton8","image": "https://robohash.org/excepturiiuremolestiae.png"},
            {"firstName": "Eleanora","lastName": "Price","email": "umcgourty9@jalbum.net","username": "umcgourty9","image": "https://robohash.org/aliquamcumqueiure.png"}
        ]';

        $fakePerson = json_decode($fakePersonData, true);
        foreach ($fakePerson as $person) {
            Person::create([
                'fname_en' => $person['firstName'],
                'lname_en' => $person['lastName'],
                'image' =>  $person['image']
            ]);
        }
    }
}
