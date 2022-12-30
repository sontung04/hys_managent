<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    //
    use Notifiable;
    protected $table = 'classes_students';
    protected $fillable = [
        'id',
        'class_id',
        'course_id',
        'student_code',
        'starttime',
        'finishtime',
        'status',
        'fees',
        'date_payment',
        'note',
        'course_where',
        'desire',
        'created_by',
        'updated_by',
    ];
}
