<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Dùng để lấy những thông tin cần thiết:
 * Tên, khóa học đang theo học, số tiền còn thiếu để gửi mail cho học viên.
 *
 * Dẫn đến template mail có sẵn.
 */

class FeeReminder extends Mailable
{
    use Queueable, SerializesModels;

    // Thông tin cần thiết để gửi mail cho học viên
    public $student_name;
    public $course_names;
    public $monies;

    /**
     * Lấy thông tin để gửi email.
     *
     * @return void
     */
    public function __construct($student_name, $course_names, $monies)
    {
        $this->student_name = $student_name;
        $this->course_names = $course_names;
        $this->monies = $monies;
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
