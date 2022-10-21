<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    use Notifiable;
    protected $table = 'attendances';
    protected $fillable = [
        'id',
        'study_id',
        'student_code',
        'student_type',
        'status',
        'note',
        'feedback',
        'question',
        'comment',
        'created_by',
        'updated_by',
    ];

}
