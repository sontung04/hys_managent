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
        'student_id',
        'status',
        'note',
        'created_by',
        'updated_by',
    ];
    
}
