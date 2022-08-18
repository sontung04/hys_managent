<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Teacher extends Model
{
    use Notifiable;

    protected $table = 'teachers';

    protected $fillable = [
        'name', 'gender', 'birthday', 'img', 'native_place', 'level', 'job', 'description',
        'status', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
