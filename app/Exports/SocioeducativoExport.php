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

class SocioeducativoExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    
    protected $exportar;

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE GENERAL SOCIOEDUCATIVO'],
            [' '],
            ['No', 'NOMBRES', 'APELLIDOS', 'DOCUMENTO', 'NUMERO DOCUMENTO', 'CODIGO', 'EMAIL', 'TELEFONO', 'COHORTE', 'GRUPO', 'ESTADO', 'ACEPTACION 1', 'ACEPTACION 2', 'TRABAJADOR', 'SALUD FISICA', 'SALUD MENTAL', 'RIESGO PSICOSOCIAL', 'FECHA SEGUIMIENTO', 'LUGAR SEGUIMIENTO', 'HORA INICIO', 'HORA FIN', 'OBJETIVOS', 'SEGUIMIENTO INDIVIDUAL', 'RIESGO INDIVIDUAL', 'SEGUIMIENTO ACADEMICO', 'RIESGO ACADEMICO', 'SEGUIMIENTO FAMILIAR', 'RIESGO FAMILIAR', 'SEGUIMIENTO ECONOMICO', 'RIESGO ECONOMICO', 'SEGUIMIENTO VIDA UNIVERSITARIA Y CIUDAD', 'RIESGO VIDA UNIVERSITARIA Y CIUDAD', 'OBSERVACIONES'],
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
                
                $event->sheet->getDelegate()->mergeCells('A2:AG2');
                
                $event->sheet->getDelegate()->getStyle('A4:AG4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A4:AG3600',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:AG2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:AG4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,
                        
                            ],
                        ]
                );

                $event->sheet->styleCells(
                    'NN4:AG4',
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
