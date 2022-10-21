<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Intern extends Model
{
    //
    use Notifiable;
    protected $table = 'interns';
    protected $fillable = [
        'student_code',
        'name',
        'phone',
        'img',
        'status',
        'starttime',
        'finishtime',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

}
