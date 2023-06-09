<?php

namespace App\Exports;

use App\Models\Research;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResearchsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Research::all();
    }
}
