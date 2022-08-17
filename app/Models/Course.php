<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Course extends Model
{
    use Notifiable;
    protected $table = 'courses';

    protected $fillable = [
        'name','fees','description','status','created_by','updated_by','created_at','updated_at'
    ];
}
