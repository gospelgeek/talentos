<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use DB;

class SocioEducationalFollowUp extends Model
{
    use SoftDeletes;
    //use Notifiable;

    protected $table = 'socio_educational_follow_ups';

    protected $primarykey = 'id';

    protected $fillable = [
        'id_student',
        'id_user',
        'tracking_detail', 
    ];

    protected $dates = ['delete_at'];

    //consulta para reporte
    public static function socioeducativo_reporte(){

        $data = DB::select("select student_profile.id, student_profile.name, student_profile.lastname, student_profile.document_number, student_profile.id_state, student_groups.id_group as grupoid,  groups.name AS grupo, cohorts.name AS cohorte, assignment_students.id_user as id_profesional, users.name as nombre_profesional, users.apellidos_user as apellido_profersional, COUNT(student_profile.id) as cantidad_seguimientos, formalizations.acceptance_v1 as aceptacion2, formalizations.acceptance_v1 as aceptacion1, max(socio_educational_follow_ups.tracking_detail) as detalle, (SELECT health_conditions.special_requirements FROM health_conditions WHERE health_conditions.id_student = student_profile.id) as caso_especial, (SELECT health_conditions.mental_health FROM health_conditions WHERE health_conditions.id_student = student_profile.id) as salud_mental
            FROM student_profile 
            INNER JOIN student_groups ON student_groups.id_student = student_profile.id
            INNER JOIN groups ON groups.id = student_groups.id_group
            INNER JOIN cohorts on cohorts.id = groups.id_cohort
            INNER JOIN assignment_students ON assignment_students.id_student = student_profile.id
            INNER JOIN users ON users.id = assignment_students.id_user
            INNER JOIN formalizations ON formalizations.id_student = student_profile.id
            INNER JOIN socio_educational_follow_ups ON socio_educational_follow_ups.id_student = student_profile.id
            WHERE student_groups.deleted_at IS null
            AND socio_educational_follow_ups.deleted_at IS null
            GROUP BY student_profile.id, student_groups.id_group,   
            assignment_students.id_user, formalizations.acceptance_v1
            ORDER BY socio_educational_follow_ups.id_student DESC");

        if($data != null){
            return $data;
        }else{
            return null;
        }
    }
    //
    
    /**
     * Relacion con los  datos que se tiene de SocioEducationalFollowUp  
     * con la tabla student_profile
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<student_profile>
     */
    public function perfilEstudiantesegui(){

        return $this->belongsTo(perfilEstudiante::class, 'id', 'id_student');
    }
}
