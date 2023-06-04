<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PreviousAcademicData extends Model
{
    protected $table = 'previous_academic_data';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'id_institution_type',
        'institution_name',
        'year_graduation',
        'bachelor_title',
        'url_academic_support',
        'icfes_date',
        'snp_register',
        'icfes_score',
        'graduate',
        'graduate_schooling',
    ];
    
    //para datos pendientes
    public static function academicos(){
        $data = DB::select("select student_profile.id, student_profile.name, 
                    student_profile.lastname,cohorts.id as 
                    idcohort, cohorts.name as cohorte, groups.id as grupo, groups.name as 
                    grupo_name,
                    (select CONCAT(users.name,' ', users.apellidos_user)profesional 
                    FROM users,assignment_students
                    WHERE users.id = assignment_students.id_user
                    and assignment_students.deleted_at is null
                    and student_profile.id = assignment_students.id_student
                    limit 1) as profesional,
                    (SELECT conditions.name FROM conditions WHERE conditions.id = 
                    student_profile.id_state) as estado,
                    (SELECT institution_types.name FROM institution_types WHERE
                    institution_types.id =                                            
                    previous_academic_data.id_institution_type) as tipo_institucion, 
                    previous_academic_data.institution_name,                     
                    previous_academic_data.year_graduation, previous_academic_data.bachelor_title,  
                    previous_academic_data.url_academic_support, previous_academic_data.icfes_date, 
                    previous_academic_data.snp_register, previous_academic_data.icfes_score
                    FROM student_profile
                    INNER JOIN student_groups ON student_groups.id_student = student_profile.id
                    INNER JOIN groups ON groups.id = student_groups.id_group
                    INNER JOIN cohorts on cohorts.id = groups.id_cohort
                    INNER JOIN previous_academic_data ON previous_academic_data.id_student =
                    student_profile.id
                    WHERE student_groups.deleted_at is null");
        
        if($data != null){
            return $data;
        }else{
            return null;
        }
    }

    /**
     * Relacion con los  datos que se tiene de previos_academic_date con la tabla institution_type 
     * 
     * @author Steven Tangarife <herson.tangarife@correounivalle.edu.co>
     * @return Collection<SocioeconomicData>
    */

    public function institutiontype(){

        return $this->hasOne(InstitutionType::class, 'id', 'id_institution_type');
    }
    
}
