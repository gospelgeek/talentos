<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseItems extends Model
{
    protected $table = 'course_items';

    protected $primarykey = 'course_id';

    protected $fillable = [
            'category_name',
            'course_id',
            'item_type',
            'item_id',
            'item_instance',
            'item_name',
    ];

}
