<?php

namespace App\Exports;

use App\perfilEstudiante;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use DB;
use Carbon\Carbon;


class SabanaExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $excel;
    
    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE GENERAL DE DATOS DEL ESTUDIANTE'],
            [' '],
            ['No.','LINEA ELEGIDA','UNIVERSIDAD','FECHA DE REGISTRO','USUARIO','NOMBRES','APELLIDOS','TIPO DE DOCUMENTO','NUMERO DE DOCUMENTO','FECHA DE EXPEDICION','EDAD','FIJO','CELULAR 1','CELULAR 2','LUGAR DE NACIMIENTO','DIRECCION DE RESIDENCIA','COMUNA','BARRIO','ZONA RURAL','ESTRATO','OCUPACION','ESTADO CIVIL','NUMERO DE HIJOS','TIEMPO EN LA RESIDENCIA','TIPO DE VIVIENDA','REGIMEN DE SALUD','CATEGORIA SISBEN','BENEFICIOS','PERSONAS EN EL HOGAR','POSICION ECONOMICA','PERSONAS DEPENDIENTES','INTERNET EN LA ZONA','INTERNET EN EL HOGAR','DISPOSITIVOS EN EL HOGAR','SEXO DEL DOCUMENTO DE IDENTIDAD','LGTBIQ+','CONDICION SOCIAL','DISCAPACIAD','ETNIA','TIPO DE INSTITUCION','NOMBRE DE INSTITUCION','AÑO GRADUACION','TITULO BACHILLER','FECHA ICFES','REGISTRO SNP','PUNTAJE ICFES','NOMBRES TUTOR','APELLIDOS TUTOR','CORREO TUTOR','TIPO DOCUMENTO TUTOR','NUMERO DOCUMENTO TUTOR','FECHA NACIMIENTO TUTOR','CELULAR TUTOR','OCUPACION TUTOR','P1(ICFES)','P2 VULNERABILIDAD','FORMULA((P1+P2)/2)','ZONA RURAL','MUJER','LGTBIQ+','DISCAPACIDAD','VICTIMA CONFLICTO','ESTRATO 1 Y 2','SISBEN (A,B,C)','AFRODESCENDIENTE','INDIGENA','MOTIVO-NO ADMITIDOS' 
            ]
            
        ];
    }

    public function __construct(array $excel)
    {
        $this->excel = $excel;
            
    }

    public function array(): array
    {
        return $this->excel;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                
                $event->sheet->getDelegate()->mergeCells('A2:BO2');
                
                $event->sheet->getDelegate()->getStyle('A4:BO4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A4:BO3001',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:BO2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:BB4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'BC4:BO4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                            'color'     => array('rgb' => 'FF0000')
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
            },
        ];
    }
}
            

