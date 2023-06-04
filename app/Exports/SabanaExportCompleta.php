<?php

namespace App\Exports;

use App\perfilEstudiante;

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

class SabanaExportCompleta implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $exportar;

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE COMPLETO DE DATOS DEL ESTUDIANTE'],
            [' '],
            ['No.','LINEA ELEGIDA','GRUPO','UNIVERSIDAD','FECHA DE REGISTRO','USUARIO','NOMBRES','APELLIDOS','ENLACE FOTO','TIPO DE DOCUMENTO','NUMERO DE DOCUMENTO','ENLACE TIPO DOCUMENTO','FECHA DE EXPEDICION','FECHA NACIMIENTO','EDAD','SEXO','GENERO','CODIGO ESTUDIANTE','NOMBRES PROFESIONAL ACOMPAÑAMIENTO','APELLIDOS PROFESIONAL ACOMPAÑAMIENTO','FIJO','CELULAR 1','CELULAR 2','DEPARTAMENTO NACIMIENTO','CIUDAD NACIMIENTO','DIRECCION DE RESIDENCIA','COMUNA','BARRIO','ZONA RURAL','ESTRATO','OCUPACION','ESTADO CIVIL','NUMERO DE HIJOS','TIEMPO EN LA RESIDENCIA','TIPO DE VIVIENDA','REGIMEN DE SALUD','ENLACE REGIMEN SALUD','CATEGORIA SISBEN','ENLACE CATEGORIA SISBEN','EPS','BENEFICIOS','PERSONAS EN EL HOGAR','POSICION ECONOMICA','PERSONAS DEPENDIENTES','INTERNET EN LA ZONA','INTERNET EN EL HOGAR','DISPOSITIVOS EN EL HOGAR','SEXO DEL DOCUMENTO DE IDENTIDAD','LGTBIQ+','CONDICION SOCIAL','ENLACE CONDICION SOCIAL','DISCAPACIAD','ETNIA','ENLACE ETNIA','TIPO DE INSTITUCION','NOMBRE DE INSTITUCION','AÑO GRADUACION','TITULO BACHILLER','ENLACE SOPORTE ACADEMICO','FECHA ICFES','REGISTRO SNP','PUNTAJE ICFES','NOMBRES TUTOR','APELLIDOS TUTOR','CORREO TUTOR','TIPO DOCUMENTO TUTOR','NUMERO DOCUMENTO TUTOR','FECHA NACIMIENTO TUTOR','CELULAR TUTOR','OCUPACION TUTOR','P1(ICFES)','P2 VULNERABILIDAD','FORMULA((P1+P2)/2)','ZONA RURAL','MUJER','LGTBIQ+','DISCAPACIDAD','VICTIMA CONFLICTO','REINTEGRACION SOCIAL','ESTRATO 1 Y 2','SISBEN (A,B,C)','AFRODESCENDIENTE','INDIGENA','MOTIVO-NO ADMITIDOS' 
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
                
                $event->sheet->getDelegate()->mergeCells('A2:CF2');
                
                $event->sheet->getDelegate()->getStyle('A4:CF4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A4:CF2960',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:CF2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:CF4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'BR4:CF4',
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
