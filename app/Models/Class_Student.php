<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Class_Student extends Model
{
    //
    use Notifiable;
    protected $table = 'classes_students';
    protected $fillable = [
        'id',
        'class_id',
        'student_id',
        'starttime',
        'endtime',
        'status',
        'fees',
        'note',
        'created_by',
        'updated_by',
    ];
}
