<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CallStudentLog extends Model
{
    use Notifiable;

    protected $table = 'call_student_logs';

    protected $fillable = [
        'id',
        'student_code',
        'agent',
        'date_call',
        'channel',
        'status',
        'note',
        'created_at',
        'updated_at',
    ];
}
