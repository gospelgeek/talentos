<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class CertificadoController extends Controller
{
    public function _constructor(){

    }

    public function certificado($id)
    {

        $now = new DateTimeZone("America/Bogota");
        $fecha = new DateTime("now", $now);
        $actual = $fecha->format('Y-m-d');

        $consulta = DB::select("SELECT id, name as nombre, lastname as apellidos, 
        (SELECT document_type.name FROM document_type WHERE document_type.id = 
        student_profile.id_document_type) as tipo_documento, document_number as numero_identificacion, 
        (SELECT (SELECT name FROM groups WHERE groups.id = student_groups.id_group) 
        FROM student_groups WHERE student_groups.id_student = student_profile.id) as grupo, 
        (SELECT (SELECT (SELECT name FROM cohorts WHERE cohorts.id = groups.id_cohort) 
        FROM groups WHERE groups.id = student_groups.id_group) FROM student_groups 
        WHERE student_groups.id_student = student_profile.id) as linea FROM student_profile 
        WHERE student_profile.document_number = ?", [$id]);

        //dd($consulta[0]->nombre);

        $pdf = PDF::loadView('pdfsreportes.certificadoPDF', [
            "data" => $consulta,
            "fecha" => $actual
        ]);

        return $pdf->stream("certificado.pdf");
    }
}
