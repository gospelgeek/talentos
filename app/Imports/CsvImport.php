<?php

namespace App\Imports;

use App\perfilEstudiante;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CsvImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    
    public function collection(Collection $rows)
    {   

    }
}
