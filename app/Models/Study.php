<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    //
    use Notifiable;
    protected $table = 'studies';
    protected $fillable = [
        'id',
        'class_id',
        'lesson_id',
        'teacher',
        'coach',
        'carer_staff',
        'daylearn',
        'location',
        'created_by',
        'updated_by',
    ];
    
}
