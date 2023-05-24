<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static findOrFail($id)
 * @method static find(int $int)
 */
class ClassPaymentLog extends Model
{
    use Notifiable;

    protected $table = 'class_payment_logs';

    protected $fillable = [
        'id',
        'course_id',
        'student_code',
        'money_paid',
        'cashier',
        'status',
        'date_paid',
        'note',
        'created_at',
        'updated_at',
    ];
}
