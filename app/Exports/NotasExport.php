<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotasExport implements FromArray, WithHeadings
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        /*foreach($this->invoices as $estudiantes){
            foreach($estudiantes as $estudiante){
                dd($estudiante);
            }
        }*/
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            ['NOMBRES','APELLIDOS','DOCUMENTO','GRUPO','LINEA','ASIGNATURAS'
            ]
            
        ];
    }
}
