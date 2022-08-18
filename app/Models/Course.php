<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Course extends Model
{
    use Notifiable;
    protected $table = 'course';

    protected $fillable = [
        'name', 'fees', 'lenght', 'description', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
