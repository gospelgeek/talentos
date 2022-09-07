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
            'SIMULACRO 1','','','','','',
            'SIMULACRO 2','','','','','',
            'SIMULACRO 3','','','','','',
            'ICFES SALIDA','','','','','',
            ],
            ['No.','NOMBRE','APELLIDOS','DOCUMENTO','LINEA','GRUPO',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES', 'TOTAL',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL',
            'LECTURA CRITICA','MATEMATICAS','CIENCIAS SOCIALES','CIENCIAS NATURALES','INGLES','TOTAL'
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
                
                $event->sheet->getDelegate()->mergeCells('A2:AK2');
                
                $event->sheet->getDelegate()->mergeCells('A3:F3');

                $event->sheet->getDelegate()->mergeCells('G3:L3');

                $event->sheet->getDelegate()->mergeCells('M3:R3');

                $event->sheet->getDelegate()->mergeCells('S3:X3');

                $event->sheet->getDelegate()->mergeCells('Y3:AD3');

                $event->sheet->getDelegate()->mergeCells('AE3:AJ3');

                $event->sheet->getDelegate()->getStyle('G3:AK3')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->getDelegate()->getStyle('A4:AK4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A4:AK2960',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:AK2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A3:AK3',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:AK4',
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
                    'M3:R3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'S3:X3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'Y3:AD3',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );
                $event->sheet->styleCells(
                    'AE3:AJ3',
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
        
                $event->sheet->getDelegate()->getStyle('S3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('Y3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('AE3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
            },
        ];
    }
      
}
