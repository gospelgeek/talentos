<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmissionScores extends Model
{
    protected $table = 'admission_scores';

    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'id_student',
        'icfes_score_p1',
        'vulnerability',
        'formula',
        'rural_zone',
        'lgtbiq',
        'woman',
        'disability',
        'victim_conflict',
        'social_reintegration',
        'strata_1_2',
        'sisben_a_b_c',
        'afro',
        'indigenous',
    ];
}
