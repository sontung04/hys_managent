<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarWeek extends Model
{
    protected $table = 'calendars_week';

    protected $fillable = [
        'title', 'description', 'address', 'area', 'group_id', 'formality',
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
