<?php

namespace App\Exports;

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

class NotasLinea3Export implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    
    protected $exportar;

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE DE CALIFICACIONES LINEA 3'],
            ['DATOS PERSONALES','','','','','','','','BIOLOGIA','','','','CONSTITUCION','','','','FISICA','','','','GEOGRAFIA','','','','HISTORIA','','','','INGLES','','','','LECTURA CRITICA','','','','MATEMATICAS','','','','QUIMICA'],
            ['Nº', 'NOMBRE', 'APELLIDOS', 'TIPO DOC.', 'Nº DOCUMENTO', 'GRUPO', 'ESTADO', 'PROFESIONAL', 'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            'ASISTENCIA PARTICIPATIVA', 'SEGUIMIENTO ACADEMICO', 'AUTOEVALUACION', 'TOTAL CURSO',
            ],
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                
                $event->sheet->getDelegate()->mergeCells('A2:AR2');

                $event->sheet->getDelegate()->mergeCells('A3:H3');
                $event->sheet->getDelegate()->mergeCells('I3:L3');
                $event->sheet->getDelegate()->mergeCells('M3:P3');
                $event->sheet->getDelegate()->mergeCells('Q3:T3');
                $event->sheet->getDelegate()->mergeCells('U3:X3');
                $event->sheet->getDelegate()->mergeCells('Y3:AB3');
                $event->sheet->getDelegate()->mergeCells('AC3:AF3');
                $event->sheet->getDelegate()->mergeCells('AG3:AJ3');
                $event->sheet->getDelegate()->mergeCells('AK3:AN3');
                $event->sheet->getDelegate()->mergeCells('AO3:AR3');
                
                $event->sheet->getDelegate()->getStyle('A4:AR4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A3:AR948',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:AR2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:AR4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'A3:AR3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'A2',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  14,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );
                
                $event->sheet->getDelegate()->getStyle('A2')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3:AR3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
