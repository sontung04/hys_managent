<?php

namespace App\Http\Controllers;

use App\Models\ClassStudent;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function __construct()
    {

    }

    public function studentList()
    {
        $students = DB::table('classes_students', 'cs')
            ->join('students as s', 'cs.student_code', '=', 's.code')
            ->select('cs.id', 's.code', 's.name', 's.gender', 's.birthday', 's.phone', 's.email', 's.facebook',
                'cs.class_id', 'cs.course_id', 'cs.status',
                DB::raw('MAX(cs.fees) as fees')
            )
            ->groupBy('s.code', 'cs.course_id')
            ->get();
        $classPaymentLogs = DB::table('classes_students', 'cs')
            ->join('class_payment_logs as cpl', 'cs.id', '=', 'cpl.cs_id')
            ->select('cs.student_code',
                DB::raw('SUM(cpl.money_paid) as money_paid')
            )
            ->groupBy('cs.student_code')
            ->get();

//        print_r($students);
//        print_r($classPaymentLogs);
//        die();
        $listStudent = [];
        foreach ($students as $student) {
            if (!isset($listStudent[$student->code])) {
                $listStudent[$student->code] = [
                  'code' => $student->code,
                  'name' => $student->name,
                  'gender' => $student->gender,
                  'birthday' => $student->birthday,
                  'phone' => $student->phone,
                  'email' => $student->email,
                  'facebook'   => $student->facebook,
                  'total_fee'  => 0,
                  'money_paid' => 0,

                ];
            }

            $listStudent[$student->code]['total_fee'] += $student->fees;
        }

        foreach ($classPaymentLogs as $log) {
            $listStudent[$log->student_code]['money_paid'] = $log->money_paid;
        }

        return view('students.fees.list', compact('listStudent'));
    }

    public function getDetailCs($id)
    {
        $student = Student::find($id);
        return view('students.fees.detail', compact('student'));
    }
}
