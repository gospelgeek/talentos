<?php

namespace App\Http\Controllers;

use App\Devices;
use App\StudentDevices;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PdfsReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('socioeducativo');
    }


    public function descargarPDFgrupos($cohorte)
    {
        //date_default_timezone_set("");
        $now = new DateTimeZone("America/Bogota");
        $fecha = new DateTime("now", $now);
        $actual = $fecha->format('Y-m-d');
        $acum = 1;

        switch ($cohorte) {

            case 1:
                $contador = 1;
                $datos = [];
                while ($contador <= 41) {
                    $datos[$contador] = DB::select("SELECT document_number, name, lastname, student_code, email FROM 
                    student_profile WHERE student_profile.id IN (SELECT student_groups.id_student FROM 
                    student_groups WHERE student_groups.id_group = ?) AND id_state = 1 ORDER BY lastname ASC", [$contador]);
                    $contador++;
                }
                
                //$student = StudentDevices::all();
                $pdf = PDF::loadView('graphics.PDF', [
                    'grupo1' => $datos[1],
                    'grupo2' => $datos[2],
                    'grupo3' => $datos[3],
                    'grupo4' => $datos[4],
                    'grupo5' => $datos[5],
                    'grupo6' => $datos[6],
                    'grupo7' => $datos[7],
                    'grupo8' => $datos[8],
                    'grupo9' => $datos[9],
                    'grupo10' => $datos[10],
                    'grupo11' => $datos[11],
                    'grupo12' => $datos[12],
                    'grupo13' => $datos[13],
                    'grupo14' => $datos[14],
                    'grupo15' => $datos[15],
                    'grupo16' => $datos[16],
                    'grupo17' => $datos[17],
                    'grupo18' => $datos[18],
                    'grupo19' => $datos[19],
                    'grupo20' => $datos[20],
                    'grupo21' => $datos[21],
                    'grupo22' => $datos[22],
                    'grupo23' => $datos[23],
                    'grupo24' => $datos[24],
                    'grupo25' => $datos[25],
                    'grupo26' => $datos[26],
                    'grupo27' => $datos[27],
                    'grupo28' => $datos[28],
                    'grupo29' => $datos[29],
                    'grupo30' => $datos[30],
                    'grupo31' => $datos[31],
                    'grupo32' => $datos[32],
                    'grupo33' => $datos[33],
                    'grupo34' => $datos[34],
                    'grupo35' => $datos[35],
                    'grupo36' => $datos[36],
                    'grupo37' => $datos[37],
                    'grupo38' => $datos[38],
                    'grupo39' => $datos[39],
                    'grupo40' => $datos[40],
                    'cohorte' => $cohorte,
                    'fecha' => $actual,
                    'cont' => $acum,
                ])->setPaper('a4');
                //$pdf->loadHTML('<h1>Test</h1>');
                //return $pdf->stream("listado-linea1-$actual.pdf");
                return $pdf->download("listado-linea1-$actual.pdf");
                break;

            case 2:
                $contador = 1;
                $gp = 1004;
                $datos = [];
                while ($contador <= 41) {
                    $datos[$contador] = DB::select("SELECT document_number, name, lastname, student_code, email FROM 
                    student_profile WHERE student_profile.id IN (SELECT student_groups.id_student FROM 
                    student_groups WHERE student_groups.id_group = ?) AND id_state = 1 ORDER BY lastname ASC", [$gp]);
                    $contador++;
                    $gp++;
                }
                
                //$student = StudentDevices::all();
                $pdf = PDF::loadView('graphics.PDF', [
                    'grupo1' => $datos[1],
                    'grupo2' => $datos[2],
                    'grupo3' => $datos[3],
                    'grupo4' => $datos[4],
                    'grupo5' => $datos[5],
                    'grupo6' => $datos[6],
                    'grupo7' => $datos[7],
                    'grupo8' => $datos[8],
                    'grupo9' => $datos[9],
                    'grupo10' => $datos[10],
                    'grupo11' => $datos[11],
                    'grupo12' => $datos[12],
                    'grupo13' => $datos[13],
                    'grupo14' => $datos[14],
                    'grupo15' => $datos[15],
                    'grupo16' => $datos[16],
                    'grupo17' => $datos[17],
                    'grupo18' => $datos[18],
                    'grupo19' => $datos[19],
                    'grupo20' => $datos[20],
                    'grupo21' => $datos[21],
                    'grupo22' => $datos[22],
                    'grupo23' => $datos[23],
                    'grupo24' => $datos[24],
                    'grupo25' => $datos[25],
                    'grupo26' => $datos[26],
                    'grupo27' => $datos[27],
                    'grupo28' => $datos[28],
                    'grupo29' => $datos[29],
                    'grupo30' => $datos[30],
                    'grupo31' => $datos[31],
                    'grupo32' => $datos[32],
                    'grupo33' => $datos[33],
                    'grupo34' => $datos[34],
                    'grupo35' => $datos[35],
                    'grupo36' => $datos[36],
                    'grupo37' => $datos[37],
                    'grupo38' => $datos[38],
                    'grupo39' => $datos[39],
                    'grupo40' => $datos[40],
                    'cohorte' => $cohorte,
                    'fecha' => $actual,
                    'cont' => $acum,
                ])->setPaper('a4');
                //$pdf->loadHTML('<h1>Test</h1>');
                //return $pdf->stream("listado-linea2-$actual.pdf");
                return $pdf->download("listado-linea2-$actual.pdf");
                break;

            case 3:
                $contador = 1;
                $gp = 50;
                $datos = [];
                while ($contador <= 41) {
                    $datos[$contador] = DB::select("SELECT document_number, name, lastname, student_code, email FROM 
                    student_profile WHERE student_profile.id IN (SELECT student_groups.id_student FROM 
                    student_groups WHERE student_groups.id_group = ?) AND id_state = 1 ORDER BY lastname ASC", [$gp]);
                    $contador++;
                    $gp++;
                }
                
                //$student = StudentDevices::all();
                $pdf = PDF::loadView('graphics.PDF', [
                    'grupo1' => $datos[1],
                    'grupo2' => $datos[2],
                    'grupo3' => $datos[3],
                    'grupo4' => $datos[4],
                    'grupo5' => $datos[5],
                    'grupo6' => $datos[6],
                    'grupo7' => $datos[7],
                    'grupo8' => $datos[8],
                    'grupo9' => $datos[9],
                    'grupo10' => $datos[10],
                    'grupo11' => $datos[11],
                    'grupo12' => $datos[12],
                    'grupo13' => $datos[13],
                    'grupo14' => $datos[14],
                    'grupo15' => $datos[15],
                    'grupo16' => $datos[16],
                    'grupo17' => $datos[17],
                    'grupo18' => $datos[18],
                    'grupo19' => $datos[19],
                    'grupo20' => $datos[20],
                    'grupo21' => $datos[21],
                    'grupo22' => $datos[22],
                    'grupo23' => $datos[23],
                    'grupo24' => $datos[24],
                    'grupo25' => $datos[25],
                    'grupo26' => $datos[26],
                    'grupo27' => $datos[27],
                    'grupo28' => $datos[28],
                    'grupo29' => $datos[29],
                    'grupo30' => $datos[30],
                    'grupo31' => $datos[31],
                    'grupo32' => $datos[32],
                    'grupo33' => $datos[33],
                    'grupo34' => $datos[34],
                    'grupo35' => $datos[35],
                    'grupo36' => $datos[36],
                    'grupo37' => $datos[37],
                    'grupo38' => $datos[38],
                    'grupo39' => $datos[39],
                    'grupo40' => $datos[40],
                    'cohorte' => $cohorte,
                    'fecha' => $actual,
                    'fecha' => $actual,
                    'cont' => $acum,
                ])->setPaper('a4');
                //$pdf->loadHTML('<h1>Test</h1>');
                //return $pdf->stream("listado-linea3-$actual.pdf");
                return $pdf->download("listado-linea3-$actual.pdf");
                break;

            default:
                return redirect('estudiante');
                break;
        }

        
    }
    
    public function PDF_estudiante($id){

        $formalizaciones = Formalization::findOrFail($id);

        $student = DB::select("SELECT *, 
        (SELECT name FROM document_type WHERE document_type.id = student_profile.id_document_type) as tipoD, 
        (SELECT name FROM birth_city WHERE birth_city.id = student_profile.id_birth_city) as ciudad , 
        (SELECT name FROM birth_departaments WHERE birth_departaments.id = student_profile.id_birth_department) as departamento, 
        (SELECT name FROM gender WHERE gender.id = student_profile.id_gender) as genero, 
        (SELECT name FROM neighborhood WHERE neighborhood.id = student_profile.id_neighborhood) as barrio 
        FROM student_profile, socioeconomic_data WHERE student_profile.id = ? AND socioeconomic_data.id_student = ?", [
            $id, $id
        ]);

        if($student[0]->photo == ""){
            $foto = null;
        }else {
            $foto = explode("/", $student[0]->photo);
            $foto = $foto[5];
        }
        
        $pdf = PDF::loadView('graphics.studentPDF', [
            "student" => $student,
            "formalization" => $formalizaciones,
            "foto" => $foto
        ])->setPaper('a4');

        return $pdf->download("estudiante-$id.pdf");

    }


}
