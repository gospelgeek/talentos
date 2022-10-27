<?php

namespace App\Exports;

//use App\perfilEstudiante;

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

class SabanaIcfesExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $exportar;

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE DE COMPARATIVO ICFES'],
            ['INFORMACION DE ESTUDIANTES', '','','','','',
            'ICFES ENTRADA','','','','','', 
            'SIMULACRO 1','','','','','','','',
            'SIMULACRO 2','','','','','','','',
            'SIMULACRO 3','','','','','','','',
            'ICFES SALIDA','','','','','','','',
            ],
            ['No.','NOMBRE','APELLIDOS','DOCUMENTO','LINEA','GRUPO',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES', 'TOTAL', 
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL', 'PUNTOS DE VARIACION', 'PORCENTAJE',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL', 'PUNTOS DE VARIACION', 'PORCENTAJE',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL', 'PUNTOS DE VARIACION', 'PORCENTAJE',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL','PUNTOS DE VARIACION', 'PORCENTAJE'
            ]
            
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
                
                $event->sheet->getDelegate()->mergeCells('A2:AS2');
                
                $event->sheet->getDelegate()->mergeCells('A3:F3');

                $event->sheet->getDelegate()->mergeCells('G3:L3');

                $event->sheet->getDelegate()->mergeCells('M3:T3');

                $event->sheet->getDelegate()->mergeCells('U3:AB3');

                $event->sheet->getDelegate()->mergeCells('AC3:AJ3');

                $event->sheet->getDelegate()->mergeCells('AK3:AR3');

                $event->sheet->getDelegate()->getStyle('G3:AS3')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->getDelegate()->getStyle('A4:AS4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A4:AS2960',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:AS2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A3:AS3',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:AS4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'A3:F3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'G3:L3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'M3:T3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'U3:AB3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'AC3:AJ3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );
                $event->sheet->styleCells(
                    'AK3:AR3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
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

                $event->sheet->getDelegate()->getStyle('A3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('G3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $event->sheet->getDelegate()->getStyle('M3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
                $event->sheet->getDelegate()->getStyle('U3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('AC3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('AK3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            },
        ];
    }
      
}