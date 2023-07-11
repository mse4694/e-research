<?php

namespace App\Imports;

use App\Models\Research;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ResearchsImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $full_name = $row['full_name'];
        $split = Str::of($full_name)->trim()->split('/[\s]+/');

        $person =  \App\Models\Person::where('fname_th', $split[count($split)-2])->where('lname_th', $split[count($split)-1])->first();
        $person_id = $person->id ?? 0;
        //logger($person_id);

        $link = Str::contains($row['link'], 'http') ? $row['link'] : '-';

        return new Research([
            'full_name' => $row['full_name'],
            'author' => $row['authors'],
            'author_id' => $row['authors_id'],
            'year' => $row['year'],
            'month' => $row['month'],
            'title' => $row['title'],
            'abstract' => $row['abstract'],
            'volume' => $row['volume'],
            'issue' => $row['issue'],
            'doi' => $row['doi'],
            'isbn' => $row['isbn'],
            'issn' => $row['issn'],
            'link' => $link,
            'author_keyword' => $row['author_keywords'],
            'person_id' => $person_id,
        ]);
    }
}
