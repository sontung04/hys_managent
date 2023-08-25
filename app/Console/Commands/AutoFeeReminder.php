<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeeReminder;
use Illuminate\Support\Facades\DB;

class AutoFeeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:feeReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fee Reminder';

    /**
     * Function lấy ra thông tin của những học viên quá hạn đóng học phí,
     * bao gồm MHV, tên, email, course_id mà HV theo học.
     *
     * @return int
     */
    public function handle()
    {

        // Lấy ra những học viên đã quá hạn 30 ngày kể từ lần thông báo cuối.
        $students = DB::table('classes_students', 'cs')
            ->join('students as s', 'cs.student_code', '=', 's.code')
            ->select('s.code', 's.name', 's.email', 'cs.course_id',
                DB::raw('MAX(cs.fees) as fees')
            )
            ->whereRaw('DATEDIFF(NOW(), cs.date_payment) > 0')
            ->whereRaw('DATEDIFF(NOW(), cs.date_payment) % 30 = 0')
            ->groupBy('s.code', 'cs.course_id')
            ->orderBy('s.code', 'DESC')
            ->get();

        // Tính số tiền của mỗi học viên đã trả.
        $classPaymentLogs = DB::table('class_payment_logs', 'cpl')
            ->select('cpl.student_code',
                DB::raw('SUM(cpl.money_paid) as money_paid')
            )
            ->groupBy('cpl.student_code')
            ->get();

        $course = DB::table('courses')->pluck('name', 'id');

        // Lưu những thông tin cần thiết để gửi email cho học viên
        $listStudent = [];
        foreach ($students as $student) {
            if (!isset($listStudent[$student->code])) {
                $listStudent[$student->code] = [
                  'id'       => $course[$student->course_id],
                  'name'     => $student->name,
                  'email'    => $student->email,
                  'total_fee'  => 0,
                  'money_paid' => 0,
                ];
            }

            $listStudent[$student->code]['total_fee'] += $student->fees;
        }

        foreach ($classPaymentLogs as $log) {
            $listStudent[$log->student_code]['money_paid'] = $log->money_paid;
        }

        // Gửi mail cho những học sinh nào chưa đóng đủ học phí
        if ($students->count() > 0) {
            foreach ($students as $student) {
                $studentInfo = $listStudent[$student->code];
                if ($studentInfo['total_fee'] > $studentInfo['money_paid']) {
                    Mail::to($studentInfo['email'])
                        ->send(new FeeReminder($studentInfo['name'],
                                               $studentInfo['id'],
                                               $studentInfo['total_fee'] - $studentInfo['money_paid']));
                }
            }
        }

        return 0;
    }
}
