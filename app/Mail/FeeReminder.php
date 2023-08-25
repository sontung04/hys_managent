<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $student_name;
    public $course_name;
    public $money;

    /**
     * Lấy thông tin để gửi email.
     *
     * @return void
     */
    public function __construct($student_name, $course_name, $money)
    {
        $this->student_name = $student_name;
        $this->course_name = $course_name;
        $this->money = $money;
    }

    /**
     * Tiêu đề và nội dung email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('THÔNG BÁO ĐÓNG HỌC PHÍ!')
            ->view('emails.feeReminder');
    }
}
