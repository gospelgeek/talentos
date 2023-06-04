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
            ['Asignatura','Grupo','Linea','Url','Sesiones Virtuales','Promedio Asistencias Virtuales','Sesiones Presenciales','Promedio Asistencias Presenciales','Total Sesiones','Promedio Asistencia General'
            ]
            
        ];
    }
}
