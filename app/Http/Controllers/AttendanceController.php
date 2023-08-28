<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Attendance;
use App\Models\Study;
use App\Services\StudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Services\PageFormService;

class AttendanceController extends Controller
{
    private $pageFormService;

    public function __construct(PageFormService $pageFormService)
    {
        $this->pageFormService = $pageFormService;
    }

    /**
     * Function lấy ra thông tin 1 lần điểm danh
     * @param Request $request
     */
    public function getInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();
        if(isset($requestData['id']) && !empty($requestData['id'])) {
            $attendance = DB::table('attendances', 'a')
                ->join('students as s', 'a.student_code', '=', 's.code')
                ->select('a.id', 'a.study_id', 'a.student_code', 'a.student_type', 's.name',
                    'a.status', 'a.note', 'a.feedback', 'a.question', 'a.comment')
                ->where('a.id', '=', $requestData['id'])->get();
            if(count($attendance)) {
                BaseHelper::ajaxResponse('success', true, $attendance[0]);
            } else {
                BaseHelper::ajaxResponse(config('app.textGetEmpty'), true, '');
            }
        }

        if(isset($requestData['study_id']) && isset($requestData['student_info']) && isset($requestData['student_type']))
        {
            $attendance = DB::table('attendances', 'a')
                ->join('students as s', 'a.student_code', '=', 's.code')
                ->select('a.id', 'a.study_id', 'a.student_code', 'a.student_type', 's.name',
                    'a.status', 'a.note', 'a.feedback', 'a.question', 'a.comment')
                ->where([
                    ['a.study_id',     '=', $requestData['study_id']],
                    ['a.student_code', '=', $requestData['student_info']],
                    ['a.student_type', '=', $requestData['student_type']],
                ])
                ->get();
            if(count($attendance)) {
                BaseHelper::ajaxResponse('success', true, $attendance[0]);
            } else {
                BaseHelper::ajaxResponse(config('app.textGetEmpty'), true, '');
            }
        }

        BaseHelper::ajaxResponse(config('app.textRequestDataErr'), false);
    }

    /**
     * Function lưu thông tin điểm danh
     * @param Request $request
     */
    public function saveInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();
//        print_r($requestData);
//        die();
        if(isset($requestData['_token'])) {
            unset($requestData['_token']);
        }
        if (!isset($requestData['id']) || empty($requestData['id'])) {
            # Create new attendance
            $attendance = new Attendance();
            $attendance->created_by = Auth::id();
            $attendance->created_at = Carbon::now();
        } else {
            #update infomation attendance
            $attendance = Attendance::find($requestData['id']);
            $attendance->updated_by = Auth::id();
            $attendance->updated_at = Carbon::now();
        }

        foreach ($requestData as $key => $val) {
            if($key == 'id') continue;
            $attendance->{$key} = $val;
        }

        try {
            $attendance->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true, $attendance);
        } catch (\Exception $exception){
//            print_r($exception->getMessage());
//            die();
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

    /**
     * Function lấy thông tin trả ra view checkin học viên
     * @param $studyid
     */
    public function formStudent($studyid) {
        $study_id = base64_decode($studyid);
        if(!$study_id || strlen($study_id) < 5) {
            return view('pages.errors.404');
        }

        $study_id = substr($study_id, 5);
        if(!is_numeric($study_id) || !Study::where('id', '=', $study_id)->exists()) {
            return view('pages.errors.404');
        }

        $studyInfo = DB::table('studies', 's')
            ->join('classes_hc as c', 's.class_id', '=', 'c.id')
            ->leftjoin('lessons as l', 's.lesson_id', '=', 'l.id')
            ->select('s.id', 's.class_id', 's.lesson_id', 's.lesson_name', 's.daylearn',
                'c.name as class_name', 'l.name as lname')
            ->where('s.id', '=', $study_id)
            ->get();

        if(!count($studyInfo)) {
            return view('pages.errors.404');
        }
        $studyInfo = $studyInfo[0];
        $timeCheckinBefore = true;
        $timeCheckinAfter  = true;
        $timeCheckin = strtotime($studyInfo->daylearn) + 72000;
        if(strtotime(Carbon::now()) < $timeCheckin) {
            $timeCheckinBefore = false;
        }

        if(strtotime(Carbon::now()) - $timeCheckin > 86400 ) {
            $timeCheckinAfter  = false;
        }

        return view('pages.forms.attenStudent', compact('studyInfo', 'timeCheckinBefore', 'timeCheckinAfter'));
    }

    /**
     * function kiểm tra mã học viên có tồn tại ở trang điểm danh
     * @param Request $request
     */
    public function checkCodeStudentAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        $studyInfo = Study::find($requestData['study_id']);

        // Lấy thông tin học viên thông qua email và số điện thoại
        $studentInfo = Student::where('email', '=', $requestData['student_info'])
            ->orWhere('phone', '=', $requestData['student_info'])->first();;

        // Kiểm tra xem requestData là số điện thoại hay email học viên có tồn tại và hợp lệ không
        if (is_numeric($requestData['student_info'])) {
            $phoneValidation = $this->pageFormService->phoneValidation($requestData['student_info']);
            if ($phoneValidation != null) {
                BaseHelper::ajaxResponse($phoneValidation['msg'], false);
            }
        }
        else {
            $emailValidation = $this->pageFormService->emailValidation($requestData['student_info']);
            if ($emailValidation != null) {
                BaseHelper::ajaxResponse($emailValidation['msg'], false);
            }
        }

        // Kiểm tra xem thành viên còn hoạt động ở CLB không
        if (!($studentInfo->status == 1)) {
            BaseHelper::ajaxResponse('Thành viên này đang không hoạt động ở CLB!');
        }

        if(!isset($requestData['student_info'])) {
            BaseHelper::ajaxResponse(config('app.textRequestDataErr'), false);
        }

        //CNL và TG không checkin vào phần của HV
        if($requestData['student_type'] == 0) {
            if($studentInfo->code == $studyInfo->carer_staff) {
                BaseHelper::ajaxResponse('Chủ nhiệm không được checkin phần của học viên!',false);
            }

            if($studentInfo->code == $studyInfo->coach) {
                BaseHelper::ajaxResponse('Trợ giảng không được checkin phần của học viên!',false);
            }
        }

        //Kiểm tra Mã Chủ nhiệm lớp có chính xác không
        if($requestData['student_type'] == 1 && $studentInfo->code != $studyInfo->carer_staff) {
            BaseHelper::ajaxResponse('Email hoặc số điện thoại của Chủ nhiệm lớp không chính xác!',false);
        }

        //Kiểm tra Mã Trợ giảng lớp có chính xác không
        if($requestData['student_type'] == 2 && $studentInfo->code != $studyInfo->coach) {
            BaseHelper::ajaxResponse('Email hoặc số điện thoại của Trợ giảng lớp không chính xác!',false);
        }

        //Kiểm tra học viên đã checkin hay chưa
        if(Attendance::where([['study_id', '=', $requestData['study_id']],
            ['student_code', '=', $studentInfo->code]])->exists()) {
            BaseHelper::ajaxResponse('Bạn đã checkin buổi học này!',false);
        }

        $studentInfo = DB::table('students')
            ->where('code', '=', $studentInfo->code)
            ->get(['code', 'name']);
        BaseHelper::ajaxResponse(config('app.textGetSuccess'),true, $studentInfo[0]);
    }

    /**
     * function Xử lý Request khi học viên Checkin
     * @param Request $request
     */
    public function formStudentSubmitAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();

        $studentInfo = Student::where('email', '=', $requestData['student_info'])
            ->orWhere('phone', '=', $requestData['student_info'])->first();

        if(Attendance::where([['study_id', '=', $requestData['study_id']],
            ['student_code', '=', $requestData['student_info']]])->exists()) {
            BaseHelper::ajaxResponse('Phản hồi của bạn đã được ghi nhận!',false);
        }

        $attendance = new Attendance();
        $attendance->study_id     = $requestData['study_id'];
        $attendance->student_code = $studentInfo->code;
            $attendance->student_type = $requestData['student_type'];
        if($requestData['student_type'] == 0) {
            $attendance->status = $requestData['status'];
        } else {
            $attendance->note   = $requestData['note'];
        }

        $attendance->feedback = $requestData['feedback'];
        $attendance->question = $requestData['question'];
        $attendance->comment  = $requestData['comment'];
        $attendance->created_at = Carbon::now();

        if($requestData['student_type'] == 1) {
            $study = Study::find($requestData['study_id']);
            $study->number_eat = $requestData['number_eat'];
            $study->number_learn = $requestData['number_learn'];
            try {
                $study->save();
            } catch (\Exception $exception){
                $msg = $exception->getMessage();
                BaseHelper::ajaxResponse($msg, false);
            }
        }

        try {
            $attendance->save();
            BaseHelper::ajaxResponse("CiT Edu cảm ơn về những góp ý của bạn!", true);
        } catch (\Exception $exception){
            $msg = $exception->getMessage();
            BaseHelper::ajaxResponse($msg, false);
        }

    }
}
