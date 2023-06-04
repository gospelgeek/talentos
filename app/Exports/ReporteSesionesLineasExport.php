<?php

namespace App\Exports;

use App\Session;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use DB;
use Carbon\Carbon;

class ReporteSesionesLineasExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    protected $exportar;

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE SESIONES LINEA 1'],
            [' '],
            ['GRUPO', 'FECHA', 'CURSO'],
        ];

    }

    public function __construct(array $exportar)
    {
        $this->exportar = $exportar;
            
    }

    public function array(): array
    {
        return $this->exportar;
    }
}
