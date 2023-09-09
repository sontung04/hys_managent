<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\CallStudentLog;
use App\Models\ClassPaymentLog;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            ->select('cs.id', 's.id as student_id', 's.code', 's.name', 's.gender', 's.birthday',
                's.phone', 's.email', 's.facebook', 'cs.class_id', 'cs.course_id', 'cs.status',
                DB::raw('MAX(cs.fees) as fees')
            )
            ->groupBy('s.code', 'cs.course_id')
            ->orderBy('s.code', 'DESC')
            ->get();

//        $classPaymentLogs = DB::table('classes_students', 'cs')
//            ->join('class_payment_logs as cpl', 'cs.id', '=', 'cpl.cs_id')
//            ->select('cs.student_code',
//                DB::raw('SUM(cpl.money_paid) as money_paid')
//            )
//            ->groupBy('cs.student_code')
//            ->toSql();

        $classPaymentLogs = DB::table('class_payment_logs', 'cpl')
            ->select('cpl.student_code',
                DB::raw('SUM(cpl.money_paid) as money_paid')
            )
            ->groupBy('cpl.student_code')
            ->get();


        $listStudent = [];
        foreach ($students as $student) {
            if (!isset($listStudent[$student->code])) {
                $listStudent[$student->code] = [
                  'id'       => $student->student_id,
                  'code'     => $student->code,
                  'name'     => $student->name,
                  'gender'   => $student->gender,
                  'birthday' => $student->birthday,
                  'phone'    => $student->phone,
                  'email'    => $student->email,
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

    /**
     * Function lấy ra chi tiết học phí,
     * lịch sử đóng tiền, lịch sử gọi điện
     * của 1 học viên và trả ra view
     *
     * @param integer $id
     */
    public function getDetailStudent($id)
    {
        $studentInfo = Student::find($id);

        $listClassStudent = DB::table('classes_students', 'cs')
            ->join('classes_hc as chc', 'cs.class_id', '=', 'chc.id')
            ->join('courses as c', 'cs.course_id', '=', 'c.id')
            ->join('studies as s', 'cs.class_id', '=', 's.class_id')
            ->select( 'cs.id', 'cs.status', 'cs.fees', 'cs.starttime', 'cs.finishtime', 'cs.date_payment',
                'cs.class_id', 'chc.name as class_name',
                'cs.course_id', 'c.name as course_name', 'c.fees as cost',
                DB::raw('COUNT(s.id) as studies')
            )
            ->where('cs.student_code', '=', $studentInfo->code)
            ->groupBy('cs.class_id')
            ->orderBy('cs.id', 'ASC')
            ->get();

        $classPaymentLogs = DB::table('class_payment_logs', 'cpl')
            ->where('cpl.student_code', '=', $studentInfo->code)
            ->get();

        $classAtten = DB::table('classes_students', 'cs')
            ->join('studies as s', 'cs.class_id', '=', 's.class_id')
            ->join('attendances as a', 's.id', '=', 'a.study_id')
            ->select('cs.class_id', DB::raw('COUNT(a.id) as learn'))
            ->where([
                ['cs.student_code', '=', $studentInfo->code],
                ['a.student_code', '=', $studentInfo->code]
            ])
            ->whereIn('a.status', [1,2])
            ->groupBy('cs.class_id')
            ->get();

        $callLogs = DB::table('call_student_logs')
            ->where('student_code', '=', $studentInfo->code)
            ->get();

        $classesInfo = [];
        $coursesInfo = [];

        foreach ($listClassStudent as $classStu) {
            $classesInfo[$classStu->class_id] = [
                'id'      => $classStu->class_id,
                'name'    => $classStu->class_name,
                'status'  => $classStu->status,
                'learn'   => 0,
                'studies' => $classStu->studies,
                'starttime'    => $classStu->starttime,
                'finishtime'   => $classStu->finishtime,
                'date_payment' => $classStu->date_payment,
            ];

            if(!isset($coursesInfo[$classStu->course_id])) {
                $coursesInfo[$classStu->course_id] = [
                    'id'      => $classStu->course_id,
                    'name'    => $classStu->course_name,
                    'status'  => $classStu->status,
                    'cost'    => $classStu->cost,
                    'fees'    => $classStu->fees,
                    'payment' => 0,
                    'logs'    => []
                ];
            } else {
                if($coursesInfo[$classStu->course_id]['fees'] < $classStu->fees) {
                    $coursesInfo[$classStu->course_id]['fees'] = $classStu->fees;
                }

                if($coursesInfo[$classStu->course_id]['status'] != $classStu->status) {
                    $coursesInfo[$classStu->course_id]['status'] = $classStu->status;
                }
            }
        }

        if(!empty($classPaymentLogs)) {
            foreach ($classPaymentLogs as $log) {
                $coursesInfo[$log->course_id]['payment'] += $log->money_paid;
                $coursesInfo[$log->course_id]['logs'][] = [
                    'id'         => $log->id,
                    'money_paid' => $log->money_paid,
                    'cashier'    => $log->cashier,
                    'status'     => $log->status,
                    'date_paid'  => $log->date_paid,
                    'note'       => $log->note,
                ];
            }
        }

        if(!empty($classAtten)) {
            foreach ($classAtten as $atten) {
                $classesInfo[$atten->class_id]['learn'] = $atten->learn;
            }
        }

        return view('students.fees.detail', compact('studentInfo',
            'classesInfo', 'coursesInfo', 'callLogs'));
    }

    /**
     * Get info record payment log by id return to Ajax
     *
     * @param Request $request
     * @param $id
     */
    public function getPaymentLogByIdAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);
        $paymentLog = ClassPaymentLog::findOrFail($id);
        $paymentLog->date_paid = $this->changeFormatDateOutput($paymentLog->date_paid);
        BaseHelper::ajaxResponse('success', true, $paymentLog);
    }

    /**
     * Function tạo lịch sử đóng học phí qua Ajax
     *
     * @param Request $request
     */
    public function paymentLogCreateAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();
        try {
            if (!isset($requestData['id']) || empty($requestData['id'])){
                # Create new class
                $classPaymentLog = new ClassPaymentLog();
                $classPaymentLog->created_at = Carbon::now();
            } else {
                #update information class
                $classPaymentLog = ClassPaymentLog::find($requestData['id']);
                $classPaymentLog->updated_at = Carbon::now();
            }
            $classPaymentLog->course_id    = $requestData['course_id'];
            $classPaymentLog->student_code = $requestData['student_code'];
            $classPaymentLog->money_paid   = $requestData['money_paid'];
            $classPaymentLog->cashier      = $requestData['cashier'];
            $classPaymentLog->status       = $requestData['status'];
            $classPaymentLog->date_paid    = $this->changeFormatDateInput($requestData['date_paid']);
            $classPaymentLog->note         = $requestData['note'];

            $classPaymentLog->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        } catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

    /**
     * Delete record payment log by id Ajax
     *
     * @param Request $request
     * @param $id
     */
    public function paymentLogDeleteAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);
        try {
            $paymentLog = ClassPaymentLog::find($id);
            if($paymentLog) {
                $this->checkEmptyDataAjax($paymentLog);
                $paymentLog->delete();
                BaseHelper::ajaxResponse('Xóa dữ liệu thành công!', true);
            }
            BaseHelper::ajaxResponse(config('app.textGetEmpty'), false);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse(config('app.textHandlingError'), false);
        }

    }

     /**
     * Get info record call log by id return to Ajax
     *
     * @param Request $request
     * @param $id
     */
    public function getCallLogByIdAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);
        $callLog = CallStudentLog::findOrFail($id);
        $callLog->date_call = $this->changeFormatDateOutput($callLog->date_call);
        BaseHelper::ajaxResponse('success', true, $callLog);
    }

    /**
     * function tạo lịch sử gọi điện cho học viên qua Ajax
     * @param Request $request
     */
    public function callLogCreateAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new class
            $callLog = new CallStudentLog();
            $callLog->created_at = Carbon::now();
        }else{
            #update infomation class
            $callLog = CallStudentLog::findOrFail($requestData['id']);
            $callLog->updated_at = Carbon::now();
        }
        $callLog->agent        = $requestData['agent'];
        $callLog->student_code = $requestData['student_code'];
        $callLog->date_call    = $this->changeFormatDateInput($requestData['date_call']);
        $callLog->channel      = $requestData['channel'];
        $callLog->status       = $requestData['statusCall'];
        $callLog->note         = $requestData['note'];

        try {
            $callLog->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        } catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

    /**
     * Delete record call log by id Ajax
     *
     * @param Request $request
     * @param $id
     */
    public function callLogDeleteAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);
        try {
            $callLog = CallStudentLog::find($id);
            if($callLog) {
                $this->checkEmptyDataAjax($callLog);
                $callLog->delete();
                BaseHelper::ajaxResponse('Xóa dữ liệu thành công!', true);
            }
            BaseHelper::ajaxResponse(config('app.textGetEmpty'), false);
        } catch (\Exception $exception) {
            BaseHelper::ajaxResponse(config('app.textHandlingError'), false);
        }

    }
}
