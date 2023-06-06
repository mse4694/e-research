<?php

namespace Database\Seeders;

//use App\Models\Person;
use App\Models\Research;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResearchsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i<=100; $i++) {
            $person_id = $i%10;
            if($person_id === 0) {
                $person_id = 10;
            }
            $person =  \App\Models\Person::find((int)$person_id);
            //echo "$person_id";
            //dd($person->fname_en);
            $digit_4_1 =  random_int(1000,9999);
            $digit_4_2 =  random_int(1000,9999);
            $digit_2_1 =  random_int(10,99);
            $digit_2_2 =  random_int(10,99);
            $digit_3_1 =  random_int(100,999);
            $digit_3_2 =  random_int(100,999);

            Research::create([
                'title' => fake()->text,
                'abstract' => fake()->sentence(50),
                'first_author' => "{$person->fname_en} {$person->lname_en}",
                'isbn' => "{$digit_2_1}-{$digit_4_1}-{$digit_3_1}",
                'issn' => "{$digit_3_2}-{$digit_2_2}-{$digit_4_2}",
                'doi' => "{$digit_2_1}.{$digit_3_2}{$digit_3_1}/".Str::random(6),
                'tags' => null,
                'person_id' => $person->id,
                'publish_date' => $this->randomDate('2010-01-01', '2023-06-01')
            ]);
        }
    }

    private function randomDate($startDate, $endDate) {
        $minTimestamp = strtotime($startDate);
        $maxTimestamp = strtotime($endDate);
        $randomTimestamp = rand($minTimestamp, $maxTimestamp);
        $randomDate = date('Y-m-d', $randomTimestamp);
        return $randomDate;
    }

}
