<?php

namespace App\Imports;

use App\Models\Research;
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
        ]);
    }
}
