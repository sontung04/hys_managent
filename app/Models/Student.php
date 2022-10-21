<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use Notifiable;

    protected $table = 'students';
    protected $fillable = [
        'id', 'code', 'name', 'gender', 'birthday', 'img', 'native_place', 'nation', 'religion',
        'citizen_identify', 'date_of_issue', 'place_of_issue','address', 'phone',
        'email', 'facebook', 'school', 'major', 'guardian_name', 'guardian_phone',
        'father', 'father_birthday', 'father_job', 'mother', 'mother_birthday', 'mother_job',
        'status', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
