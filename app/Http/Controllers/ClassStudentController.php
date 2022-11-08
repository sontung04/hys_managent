<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\ClassHc;
use App\Models\ClassStudent;
use App\Models\Student;
use App\Services\StudentServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassStudentController extends Controller
{

    private $studentService;

    public function __construct(StudentServices $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Function thêm 1 học viên vào 1 lớp học
     * Kiểm tra điều kiện tham gia lớp của học viên đó
     * @param Request $request
     */
    public function addStudentToClassAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        $class = DB::table('classes_hc')
            ->where('id', '=', $requestData['class_id'])
            ->get(['coach', 'carer_staff', 'status']);

        if ($class[0]->status == 3) {
            BaseHelper::ajaxResponse('Lớp học đã hoàn thành', false);
        }

        if (isset($requestData['student_code'])) {
            $student = DB::table('students')
                ->where('code', '=', $requestData['student_code'])
                ->get(['id', 'code', 'name', 'birthday', 'phone']);

            if (empty($student[0]->code) || $student[0]->code == $class[0]->coach || $student[0]->id == $class[0]->carer_staff) {
                BaseHelper::ajaxResponse('Mã học viên không hợp lệ!', false);
            }

            $course = DB::table('courses')
                ->join('classes_hc', 'classes_hc.course_id', '=', 'courses.id')
                ->where('classes_hc.id', '=', $requestData['class_id'])
                ->get('courses.*');

            $checkLearned = DB::table('courses')
                ->join('classes_hc', 'courses.id', '=', 'classes_hc.course_id')
                ->join('classes_students', 'classes_hc.id', '=', 'classes_students.class_id')
                ->where([
                    ['courses.id', '=', $course[0]->id],
                    ['classes_students.student_code', '=', $student[0]->code]
                ])
                ->get('classes_students.status');

            if (count($checkLearned) != 0){
                for($i = 0; $i < count($checkLearned); $i++) {
                    if ($checkLearned[$i]->status == 0 ) {
                        BaseHelper::ajaxResponse('Học viên đã hoàn thành khóa học!', false);
                    } elseif ($checkLearned[$i]->status == 1 ){
                        BaseHelper::ajaxResponse('Học viên đã có trong danh sách lớp học hoặc đang học lớp khác cùng khóa học!', false);
                    }
                }
            }

            if ($course[0]->length >= 10) {
                $fees = 500000;
            } else $fees = 480000;

            try {
                $classStudentRecord = DB::table('classes_students')
                    ->insert([
                        'class_id'     => $requestData['class_id'],
                        'student_code' => $student[0]->code,
                        'starttime'    => $this->changeFormatDateInput($requestData['starttime']),
                        'finishtime'   => $this->changeFormatDateInput($requestData['finishtime']),
                        'note'         => $requestData['note'],
                        'fees'         => $fees,
                        'status'       => $requestData['status'],
                        'course_where' => $requestData['course_where'],
                        'desire'       => $requestData['desire'],
                        'created_by'   => Auth::id(),
                        'created_at'   => Carbon::now()
                    ]);
                BaseHelper::ajaxResponse('Thêm học viên vào lớp thành công!', true);
            } catch (\Exception $exception){
                BaseHelper::ajaxResponse(config('app.textSaveError'), false);
            }

        } else {
            BaseHelper::ajaxResponse(config('app.textRequestDataErr'), false);
        }

    }

    /**
     * Function lấy ra thông tin cơ bản 1 học viên trong 1 lớp
     * Return Data qua Ajax
     * @param $id (class_student record id)
     * @param Request $request
     */
    public function getInfoAjax($id, Request $request)
    {
        $this->checkRequestAjax($request);

        $data = DB::table('classes_students', 'cs')
            ->join('students as s', 'cs.student_code', '=', 's.code')
            ->select('s.id as student_id', 'cs.student_code',  's.name', 's.phone', 's.email', 's.birthday', 's.native_place',
                'cs.id', 'cs.starttime', 'cs.finishtime', 'cs.course_where', 'cs.desire', 'cs.status')
            ->where('cs.id', '=', $id)
            ->get();

        $data[0]->birthday   = $this->changeFormatDateOutput($data[0]->birthday);
        $data[0]->starttime  = $this->changeFormatDateOutput($data[0]->starttime);
        $data[0]->finishtime = $this->changeFormatDateOutput($data[0]->finishtime);

        BaseHelper::ajaxResponse('Success', true, $data[0]);
    }

    /**
     * function update thông tin cơ bản của 1 học viên trong 1 lớp
     * @param Request $request
     */
    public function updateInfoAjax( Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (isset($requestData['id']) && !empty($requestData['id'])) {

            /* Update Record Class student */
            $classStudent = ClassStudent::find($requestData['id']);
            $classStudent->note         = $requestData['note'];
            $classStudent->starttime    = $this->changeFormatDateInput($requestData['starttime']);
            $classStudent->finishtime   = $this->changeFormatDateInput($requestData['finishtime']);
            $classStudent->status       = $requestData['status'];
            $classStudent->course_where = $requestData['course_where'];
            $classStudent->desire       = $requestData['desire'];
            $classStudent->updated_by   = Auth::id();
            $classStudent->updated_at   = Carbon::now();

            /* Update Record Student */
            $student = Student::find($requestData['student_id']);
            $student->name         = $requestData['name'];
            $student->birthday     = $this->changeFormatDateInput($requestData['birthday']);
            $student->phone        = $requestData['phone'];
            $student->email        = $requestData['email'];
            $student->native_place = $requestData['native_place'];
            $student->updated_by   = Auth::id();
            $student->updated_at   = Carbon::now();

            try {
                $classStudent->save();
                $student->save();
                BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
            } catch (\Exception $exception){
                BaseHelper::ajaxResponse(config('app.textSaveError'), false);
            }

        } else {
            BaseHelper::ajaxResponse(config('app.textRequestDataErr'), false);
        }
    }

    /**
     * Page Form đăng ký nhập học vào 1 class
     * @param $classid
     */
    public function formRegister($classid) {
        $class_id = base64_decode($classid);
        if(!$class_id || strlen($class_id) < 5) {
            return view('pages.404');
        }

        $class_id = substr($class_id, 5);
        if(!is_numeric($class_id) || !ClassHc::where('id', '=', $class_id)->exists()) {
            return view('pages.404');
        }
        $classInfo = DB::table('classes_hc', 'chc')
            ->join('courses as c', 'chc.course_id', '=', 'c.id')
            ->select('chc.id', 'chc.name', 'chc.status', 'chc.course_id', 'c.length', 'c.fees')
            ->where('chc.id', '=', $class_id)
            ->get();
        $classInfo = $classInfo[0];

        return view('pages.forms.registerClass', compact('classInfo'));
    }

    /**
     * function kiểm tra thông tin 1 học viên trước khi đăng ký lớp
     * Trả ra dữ liệu học viên nếu học viên đó hợp lệ
     * @param Request $request
     */
    public function checkInfoByCodeAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();

        if (!StudentServices::checkIssetByCode($requestData['student_code'])) {
            BaseHelper::ajaxResponse('Mã học viên không chính xác!',false);
        }

        if(ClassStudent::where([['class_id', '=', $requestData['class_id']],
            ['student_code', '=', $requestData['student_code']]])->exists()) {
            BaseHelper::ajaxResponse('Học viên đã tham gia lớp học!',false);
        }

        $student = Student::where('code', '=', $requestData['student_code'])->get();
        $student = $student[0];
        $student->birthday        = $this->changeFormatDateOutput($student->birthday);
        $student->date_of_issue   = $this->changeFormatDateOutput($student->date_of_issue);
        $student->father_birthday = $this->changeFormatDateOutput($student->father_birthday);
        $student->mother_birthday = $this->changeFormatDateOutput($student->mother_birthday);

        BaseHelper::ajaxResponse(config('app.textGetSuccess'),true, $student);
    }

    /**
     * function submit form đăng ký học viên vào lớp
     * @param Request $request
     */
    public function submitFormRegisterAjax(Request $request)
    {
        $this->checkRequestAjax($request);
        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            if(!$this->checkDuplicateVal('students', 'phone', $requestData['phone'])) {
                BaseHelper::ajaxResponse('SĐT của bạn bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại SĐT của bạn!', false);
            }

            if(!$this->checkDuplicateVal('students', 'email', $requestData['email'])) {
                BaseHelper::ajaxResponse('Email của bạn bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại Email của bạn!', false);
            }

            # create a new student
            $student = new Student();
            $student->code       = $this->studentService->createNewCodeStudent();
            $student->created_at = Carbon::now();
        } else {
            # update student
            $student = Student::find($requestData['id']);

            if($student->phone != $requestData['phone'] && !$this->checkDuplicateVal('students', 'phone', $requestData['phone'])) {
                BaseHelper::ajaxResponse('SĐT của bạn bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại SĐT của bạn!', false);
            }

            if($student->email != $requestData['email'] && !$this->checkDuplicateVal('students', 'email', $requestData['email'])) {
                BaseHelper::ajaxResponse('Email của bạn bị trùng với một học viên khác! <br> Vui lòng kiểm tra lại Email của bạn!', false);
            }

            $student->updated_at = Carbon::now();
        }

        $student->name              = $requestData['name'];
        $student->gender            = $requestData['gender'];
        $student->birthday          = $this->changeFormatDateInput($requestData['birthday']);
        $student->img               = config('app.avatarDefault');
        $student->native_place      = $requestData['native_place'];
        $student->nation            = $requestData['nation'];
        $student->religion          = $requestData['religion'];
        $student->citizen_identify  = $requestData['citizen_identify'];
        $student->date_of_issue     = $this->changeFormatDateInput($requestData['date_of_issue']);
        $student->place_of_issue    = $requestData['place_of_issue'];
        $student->address           = $requestData['address'];
        $student->phone             = $requestData['phone'];
        $student->email             = $requestData['email'];
        $student->facebook          = $requestData['facebook'];
        $student->school            = $requestData['school'];
        $student->major             = $requestData['major'];
        $student->guardian_name     = $requestData['guardian_name'];
        $student->guardian_phone    = $requestData['guardian_phone'];
        $student->father            = $requestData['father'];
        $student->father_birthday   = $this->changeFormatDateInput($requestData['father_birthday']);
        $student->father_job        = $requestData['father_job'];
        $student->mother            = $requestData['mother'];
        $student->mother_birthday   = $this->changeFormatDateInput($requestData['mother_birthday']);;
        $student->mother_job        = $requestData['mother_job'];

        try {
            $student->save();

            $classStudent = new ClassStudent();
            $classStudent->class_id     = $requestData['class_id'];
            $classStudent->student_code = $student->code;
            $classStudent->desire       = $requestData['desire'];
            $classStudent->course_where = $requestData['course_where'];
            if($requestData['class_length'] < 10) {
                $classStudent->fees = $requestData['class_fee'];
            } else {
                $classStudent->fees = 500000;
            }
            $classStudent->starttime  = Carbon::now();
            $classStudent->created_at = Carbon::now();

            $classStudent->save();
            BaseHelper::ajaxResponse('Chúc mừng bạn đã đăng ký học thành công!',true, $student->code);
        }catch (\Exception $exception){
//            $msg = $exception->getMessage();
//            print_r($exception->getMessage());
//            die();
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }
}
