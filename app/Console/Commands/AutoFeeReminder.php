<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeeReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $students = DB::table('classes_students as cs')
            ->join('students as s', 'cs.student_code', '=', 's.code')
            ->select('s.code', 's.name', 's.email', 'cs.course_id', 'cs.date_payment',
                DB::raw('MAX(cs.fees) as fees'),
                DB::raw('(SELECT COALESCE(SUM(cpl.money_paid), 0) FROM class_payment_logs cpl
                WHERE cpl.student_code = s.code AND cpl.course_id = cs.course_id) as money_paid'),
                DB::raw('DATE(cs.finishtime) as finishtime')
            )
            ->whereRaw("DATE_FORMAT(cs.date_payment, '%d') = DATE_FORMAT(CURRENT_DATE, '%d')")
            ->whereRaw("DATE_FORMAT(cs.date_payment, '%m') = DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%m')")
            ->orWhereNull('cs.date_payment')
            ->whereNotNull('cs.finishtime') // De tam
            ->havingRaw('fees > money_paid')
            ->groupBy('s.code', 'cs.course_id')
            ->orderBy('s.code', 'DESC')
            ->get();

        Log::info(print_r($students));

        $course = DB::table('courses')->pluck('name', 'id');

        // Lưu những thông tin cần thiết để gửi email cho học viên
        $listStudent = [];
        foreach ($students as $student) {
            $listStudent[$student->code][$student->course_id] = [
                'id'            => $course[$student->course_id],
                'name'          => $student->name,
                'email'         => $student->email,
                'finishtime'    => $student->finishtime,
                'fees'          => $student->fees,
                'money_paid'    => $student->money_paid,
            ];

            $studentInfo = $listStudent[$student->code][$student->course_id];

            $three_months_later = Carbon::parse($studentInfo['finishtime'])
                ->copy()->addMonthNoOverflow(3)->format('Y-m-d');

            if ($three_months_later == now()->format('Y-m-d') || $student->date_payment != NULL) {
                if ($studentInfo['fees'] > $studentInfo['money_paid']) {
                    try {
                        Mail::to($studentInfo['email'])
                        ->send(new FeeReminder($studentInfo['name'],
                                               $studentInfo['id'],
                                               $studentInfo['fees'] - $studentInfo['money_paid']));
                    } catch (\Exception $e) {
                        Log::error('Error sending email: ' . $e->getMessage());
                    }
                }
            }
        }

        return 0;
    }
}
