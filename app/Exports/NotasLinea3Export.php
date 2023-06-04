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
            ['DATOS PERSONALES','','','','','','','','BIOLOGIA','','','','','','','','',
            'DIALOGO DE SABERES Y ORIENTACION VOCACIONAL','','','','','','','','','CONSTITUCION','','','','','','','','',
            'FISICA','','','','','','','','','GEOGRAFIA','','','','','','','','','HISTORIA','','','','','','','','',
            'INGLES','','','','','','','','','LECTURA CRITICA','','','','','','','','','MATEMATICAS','','','','','','','','',
            'PRACTICAS ARTISTICAS Y HORIZONTE SOCIO OCUPACIONAL','','','','','','','','','QUIMICA','','','','','','','','',
            'TECNOLOGIA DE LA INFORMACION Y LAS COMUNICACIONES'],
            ['Nº', 'NOMBRE', 'APELLIDOS', 'TIPO DOC.', 'Nº DOCUMENTO', 'GRUPO', 'ESTADO', 'PROFESIONAL', 
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',
            'DOCENTE','ITEMS ASISTENCIA','ASISTENCIA PARTICIPATIVA','ITEMS SEGUIMIENTO','SEGUIMIENTO ACADEMICO','ITEMS AUTOEVALUACION', 'AUTOEVALUACION', 'ITEMS HUERFANOS','TOTAL CURSO',],
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
                
                $event->sheet->getDelegate()->mergeCells('A2:DL2');

                $event->sheet->getDelegate()->mergeCells('A3:H3');
                $event->sheet->getDelegate()->mergeCells('I3:Q3');
                $event->sheet->getDelegate()->mergeCells('R3:Z3');
                $event->sheet->getDelegate()->mergeCells('AA3:AI3');
                $event->sheet->getDelegate()->mergeCells('AJ3:AR3');
                $event->sheet->getDelegate()->mergeCells('AS3:BA3');
                $event->sheet->getDelegate()->mergeCells('BB3:BJ3');
                $event->sheet->getDelegate()->mergeCells('BK3:BS3');
                $event->sheet->getDelegate()->mergeCells('BT3:CB3');
                $event->sheet->getDelegate()->mergeCells('CC3:CK3');
                $event->sheet->getDelegate()->mergeCells('CL3:CT3');
                $event->sheet->getDelegate()->mergeCells('CU3:DC3');
                $event->sheet->getDelegate()->mergeCells('DD3:DL3');
                
                $event->sheet->getDelegate()->getStyle('A4:DL4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A3:DL948',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:DL2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:DL4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'A3:DL3',
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
                $event->sheet->getDelegate()->getStyle('A3:DL3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
