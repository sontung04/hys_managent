<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeeReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Dùng để lấy thông tin của những học viên quá hạn đóng học phí,
 * bao gồm MHV, tên, email, course_id mà HV theo học.
 *
 * Gửi số tiền còn thiếu cho học viên theo từng khóa học.
 */

class CronFeeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:CronFeeReminder';

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
     */
    public function handle()
    {

        // Lấy ra những học viên đã quá hạn 30 ngày kể từ lần thông báo cuối.
        $students = DB::table('classes_students as cs')
            ->join('students as s', 'cs.student_code', '=', 's.code')
            ->select('s.code', 's.name', 's.email', 'cs.course_id', 'cs.date_payment',
                DB::raw('MAX(cs.fees) as fees'),
                DB::raw('(SELECT COALESCE(SUM(cpl.money_paid), 0)
                          FROM class_payment_logs cpl
                          WHERE cpl.student_code = s.code AND cpl.course_id = cs.course_id)
                          as money_paid'),
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

        $course = DB::table('courses')->pluck('name', 'id');

        Log::info(print_r($students));

        // Lưu những thông tin cần thiết để gửi email cho học viên
        $listStudent = [];
        $count = 0;
        foreach ($students as $student) {
            if (isset($listStudent[$student->code])) {
                $listStudent[$student->code]['id'][] = $course[$student->course_id];
                $listStudent[$student->code]['money_left'][] = $student->fees - $student->money_paid;
            }
            else {
                $listStudent[$student->code] = [
                    'id'            => [$course[$student->course_id]],
                    'name'          => $student->name,
                    'email'         => $student->email,
                    'finishtime'    => $student->finishtime,
                    'money_left'    => [$student->fees - $student->money_paid],
                ];
            }

            $studentInfo = $listStudent[$student->code];
            $count++;

            $three_months_later = Carbon::parse($studentInfo['finishtime'])
                ->copy()->addMonthNoOverflow(3)->format('Y-m-d');

            if ($three_months_later == now()->format('Y-m-d') || $student->date_payment != NULL) {
                if ($count == count($studentInfo['id'])) {
                    try {
                        Mail::to($studentInfo['email'])
                        ->send(new FeeReminder($studentInfo['name'],
                                                $studentInfo['id'],
                                                $studentInfo['money_left']));
                    } catch (\Exception $e) {
                        Log::error('Error sending email: ' . $e->getMessage());
                    }
                    $count = 0;
                }
            }
        }
    }
}
