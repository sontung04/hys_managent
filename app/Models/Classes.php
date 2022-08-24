<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    protected $fillable = [
        'id',
        'course_id',
        'name',
        'carer_staff',
        'coach',
        'starttime',
        'finishtime',
        'status',
    ];
}
