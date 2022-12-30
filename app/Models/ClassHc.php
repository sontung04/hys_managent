<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ClassHc extends Model
{
    use Notifiable;
    protected $table = 'classes_hc';

    protected $fillable = [
        'id',
        'course_id',
        'name',
        'carer_staff',
        'coach',
        'starttime',
        'finishtime',
        'status',
        'reg_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
