<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ClassPaymentLog extends Model
{
    use Notifiable;

    protected $table = 'class_payment_logs';

    protected $fillable = [
        'id',
        'cs_id',
        'money_paid',
        'cashier',
        'status',
        'date_paid',
        'note',
        'created_at',
        'updated_at',
    ];
}
