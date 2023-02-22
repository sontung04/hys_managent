<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lesson extends Model
{
    use Notifiable;

    protected $table = 'lessons';

    protected $fillable = [
        'name', 'teacher_id', 'description', 'question', 'document', 'homework', 'course_id', 'status', 'order',
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
