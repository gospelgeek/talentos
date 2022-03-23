<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteExport implements FromArray, WithHeadings
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            ['Course_id','Shortname','Total Sesiones','Total Asistencias','Promedio Asistencias'
            ]
            
        ];
    }
}
