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

class NotasLinea2Export implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    
    protected $exportar;

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE DE CALIFICACIONES LINEA 2'],
            ['DATOS PERSONALES','','','','','','','', 'JORNADAS DE ACCIÓN CIUDADANA','','','','','','','', 
            'ARTES: CONOCIMIENTO EN ACCION','','','','','','','','BIOLOGIA','','','','','','','', 
            'DEPORTE Y SALUD INTEGRAL','','','','','','','',
            'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL','','','','','','','', 'CONSTITUCIÓN','','','','','','','', 
            'FISICA','','','','','','','', 'GEOGRAFIA','','','','','','','', 'HISTORIA','','','','','','','',
            'INGLES','','','','','','','', 'LECTURA CRITICA','','','','','','','', 'MATEMATICAS','','','','','','','', 
            'QUIMICA','','','','','','','', 'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES'],
            ['Nº', 'NOMBRE', 'APELLIDOS', 'TIPO DOC.', 'Nº DOCUMENTO', 'GRUPO', 'ESTADO', 'PROFESIONAL', 
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',],
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
                
                $event->sheet->getDelegate()->mergeCells('A2:BP2');

                $event->sheet->getDelegate()->mergeCells('A3:H3');
                $event->sheet->getDelegate()->mergeCells('I3:P3');
                $event->sheet->getDelegate()->mergeCells('Q3:X3');
                $event->sheet->getDelegate()->mergeCells('Y3:AF3');
                $event->sheet->getDelegate()->mergeCells('AG3:AN3');
                $event->sheet->getDelegate()->mergeCells('AO3:AV3');
                $event->sheet->getDelegate()->mergeCells('AW3:BD3');
                $event->sheet->getDelegate()->mergeCells('BE3:BL3');
                $event->sheet->getDelegate()->mergeCells('BM3:BT3');
                $event->sheet->getDelegate()->mergeCells('BU3:CB3');
                $event->sheet->getDelegate()->mergeCells('CC3:CJ3');
                $event->sheet->getDelegate()->mergeCells('CK3:CR3');
                $event->sheet->getDelegate()->mergeCells('CS3:CZ3');
                $event->sheet->getDelegate()->mergeCells('DA3:DH3');
                $event->sheet->getDelegate()->mergeCells('DI3:DP3');
                
                $event->sheet->getDelegate()->getStyle('A4:DP4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A3:DP895',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:DP2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:DP4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'A3:DP3',
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
                $event->sheet->getDelegate()->getStyle('A3:DP3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
