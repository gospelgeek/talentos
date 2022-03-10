<?php

namespace App\Exports;

use App\perfilEstudiante;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;
use DB;



class SabanaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
     

  

    public function headings(): array
    {
        return [
            [' '],
            ['REPORTE GENERAL DE DATOS DEL ESTUDIANTE'],
            [' '],
            ['ID','FOTO','NOMBRES','APELLIDOS','TIPO DOCUMENTO','NUMERO DOCUMENTO','FECHA EXPEDICION','EMAIL','FECHA NACIMIENTO','EDAD','DEPARTAMENTO NACIMIENTO','CIUDAD NAIMIENTO','SEXO','GENERO','TELEFONO PRINCIPAL','TELEFONO ALTERNATIVO','COMUNA','BARRIO','CODIGO ESTUDIANTE','DIRECCION','TUTOR','ID_MOODLE','GRUPO','COHORTE','OCUPACION','ESTADO CIVIL','NUMERO HIJOS','TIEMPO EN RESIDENCIA','VIVIENDA','REGIMEN SALUD','URL REGIMEN SALUD','CATEGORIA SISBEN','URL CATEGORIA SISBEN','BENEFICIOS','PERSONAS EN LA FAMILIA','POSICION ECONOMICA','PERSONAS DEPENDIENTES','INTERNEN EN LA ZONA','INTERNET EN EL HOGAR','SEXO DOCUMENTO','CONDICION SOCIAL','URL CONDICION SOCIAL','DISCAPACIDAD','ETNIA','URL ETNIA','TIPO INSTITUCION','AÑO GRADUACION','TITULO BACHILLER','URL SOPORTE ACADEMICO','FECHA ICFES','REGISTRO SNP','PUNTAJE ICFES','GRADUADO','NOMBRE INSTITUCION','PUNTAJE ICFES(P1)','VULNERABILIDAD','FORMULA','ZONA RURAL','LGTBIQ+','DISCAPACIDAD','VICTIMA CONFLICTO','REINTEGRACION SOCIAL','ESTRATO 1_2','SISBEN A_B_C','AFRO','INDIGENA'
            ]
            
        ];
    }




    public function collection()
    {
        $datos = collect(DB::select("select student_profile.id, student_profile.photo, student_profile.name, 
                student_profile.lastname,
                (SELECT document_type.name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipoDocuemnto,
                student_profile.document_number, student_profile.document_expedition_date, student_profile.email, student_profile.birth_date,
                YEAR(CURDATE())-YEAR(student_profile.birth_date) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(student_profile.birth_date,'%m-%d'), 0 , -1 ) as edad,
                (SELECT birth_departaments.name FROM birth_departaments WHERE birth_departaments.id = student_profile.id_birth_department) as departamento,
                (SELECT birth_city.name FROM birth_city WHERE birth_city.id = student_profile.id_birth_city) as ciudad,
                student_profile.sex,
                (SELECT gender.name FROM gender WHERE gender.id = student_profile.id_gender) as genero,
                student_profile.cellphone, student_profile.phone,
                (SELECT comune.name FROM comune WHERE comune.id = student_profile.id_commune)as comuna,
                (SELECT neighborhood.name FROM neighborhood WHERE neighborhood.id = student_profile.id_neighborhood) as barrio,
                student_profile.student_code, student_profile.direction,
                (SELECT tutor.name FROM tutor WHERE tutor.id = student_profile.id_tutor) as tutor,
                student_profile.id_moodle,
                (SELECT groups.name FROM groups WHERE student_groups.id_group = groups.id) as grupo,
                (SELECT cohorts.name FROM cohorts WHERE groups.id_cohort = cohorts.id) as cohorte,
                (SELECT occupations.name FROM occupations WHERE occupations.id = socioeconomic_data.id_ocupation) as ocupacion,
                (SELECT civil_statuses.name FROM civil_statuses WHERE civil_statuses.id = socioeconomic_data.id_civil_status) as estadocivil,
                socioeconomic_data.children_number,
                (SELECT recidence_times.name FROM recidence_times WHERE recidence_times.id = socioeconomic_data.id_residence_time) as tiempoResidencia,
                (SELECT housing_types.name FROM housing_types WHERE housing_types.id = socioeconomic_data.id_housing_type) as vivienda,
                (SELECT health_regimes.name FROM health_regimes WHERE health_regimes.id = socioeconomic_data.id_health_regime) as regimen,
                socioeconomic_data.url_health_regime, socioeconomic_data.sisben_category, socioeconomic_data.url_sisben_category,
                (SELECT benefits.name FROM benefits WHERE benefits.id = socioeconomic_data.id_benefits) as beneficios,
                socioeconomic_data.household_people, socioeconomic_data.economic_possition, socioeconomic_data.dependent_people, socioeconomic_data.internet_zon, socioeconomic_data.internet_home, socioeconomic_data.sex_document_identidad,
                (SELECT social_conditions.name FROM social_conditions WHERE social_conditions.id = socioeconomic_data.id_social_conditions) as condicion,
                socioeconomic_data.url_social_conditions,
                (SELECT disabilities.name FROM disabilities WHERE disabilities.id = socioeconomic_data.id_disability) as discapacidad,
                (SELECT ethnicities.name FROM ethnicities WHERE ethnicities.id = socioeconomic_data.id_ethnicity) as etnia,
                socioeconomic_data.url_ethnicity,
                (SELECT institution_types.name FROM institution_types WHERE institution_types.id = previous_academic_data.id_institution_type) as tipoInstitucion,
                previous_academic_data.year_graduation, previous_academic_data.bachelor_title, previous_academic_data.url_academic_support, previous_academic_data.icfes_date, previous_academic_data.snp_register, previous_academic_data.icfes_score, previous_academic_data.graduate, previous_academic_data.institution_name,
                admission_scores.icfes_score_p1, admission_scores.vulnerability, admission_scores.formula, admission_scores.rural_zone,
                admission_scores.lgtbiq, admission_scores.disability, admission_scores.victim_conflict, admission_scores.social_reintegration, admission_scores.strata_1_2, admission_scores.sisben_a_b_c, admission_scores.afro, admission_scores.indigenous
                FROM student_profile, student_groups, groups, socioeconomic_data, previous_academic_data, admission_scores
                WHERE student_profile.id = student_groups.id_student
                AND student_groups.id_group = groups.id
                AND student_profile.id = socioeconomic_data.id_student
                AND student_profile.id = previous_academic_data.id_student
                AND student_profile.id = admission_scores.id_student",[]));
            
        return $datos;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                
                $event->sheet->getDelegate()->mergeCells('A2:BN2');
                
                $event->sheet->getDelegate()->getStyle('A4:BN4')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('C0C0C0');

                $event->sheet->styleCells(
                    'A4:BN3001',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A2:BN2',[
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ]      
                    ]
                );

                $event->sheet->styleCells(
                    'A4:BN4',
                        [
                            'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  13,
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
            },
        ];
    }
}
            
           
