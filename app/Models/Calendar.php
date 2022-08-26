<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Calendar extends Model
{
    //
    use Notifiable;
    protected $table = 'calendars';
    protected $fillable = [
        'id',
        'title',
        'description',
        'starttime',
        'endtime',
        'group_id',
        'area',
        'address',
        'formality',
        'created_by',
        'updated_by',
    ];
}
