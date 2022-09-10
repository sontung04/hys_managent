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
        'student_id',
        'starttime',
        'finishtime',
        'status',
        'fees',
        'note',
        'created_by',
        'updated_by',
    ];
}
