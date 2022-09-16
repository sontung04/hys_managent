<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\ClassHc;
use App\Models\Study;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassHcController extends Controller
{
    public function __construct()
    {

    }

    public function list()
    {
        $classes = ClassHc::all();
        $courses = DB::table('courses')->select('id', 'name')->get();
        $coursesName = [];
        foreach ($courses as $course) {
            $coursesName[$course->id] = $course->name;
        }
        return view('classes.list',compact('classes', 'coursesName'));
    }

    public function getInfoAjax(Request $request, $id)
    {
        $this->checkRequestAjax($request);

        $class = ClassHc::findOrFail($id);
        $class->starttime = $this->changeFormatDateOutput($class->starttime);
        $class->finishtime = $this->changeFormatDateOutput($class->finishtime);
        BaseHelper::ajaxResponse('success', true, $class);
    }

    public function saveInfoAjax(Request $request)
    {
        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new class
            $class = new ClassHc();
            $class->created_by = Auth::id();
            $class->created_at = Carbon::now();
        }else{
            #update infomation class
            $class = ClassHc::findOrFail($requestData['id']);
            $class->updated_by = Auth::id();
            $class->updated_at = Carbon::now();
        }
        $class->name        = $requestData['name'];
        $class->course_id   = $requestData['course_id'];
        $class->carer_staff = $requestData['carer_staff'];
        $class->coach       = $requestData['coach'];
        $class->status      = $requestData['status'];
        $class->starttime   = $this->changeFormatDateInput($requestData['starttime']);
        $class->finishtime  = $this->changeFormatDateInput($requestData['finishtime']);

        try {
            $class->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }

    public function listStudentClass($id){
        $class = ClassHc::findOrFail($id);
        $students = DB::table('students')
            ->join('classes_students', 'students.id', '=', 'classes_students.student_id')
            ->where('classes_students.class_id', '=', $id)
            ->orderBy('name', 'desc')
            ->select('students.*','classes_students.status')
            ->get();
        return view('classes.listStudent',compact('students','class'));
    }

    public function saveStudentClassAjax(Request $request){

        $this->checkRequestAjax($request);

        $requestData = $request->all();
        if (isset($requestData['name']) && isset($requestData['phone']) && isset($requestData['birthday'])) {
            $student = DB::table('students')
                ->where([
                    ['name', 'LIKE', '%' . $requestData['name'] . '%'],
                    ['birthday', 'LIKE', $requestData['birthday'] . '%'],
                    ['phone', '=', $requestData['phone']]
                ])
                ->get(['id', 'name', 'birthday', 'phone']);

            if (empty($student[0]->id)) {
                BaseHelper::ajaxResponse('Dữ liệu học viên không chính xác');
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
                    ['classes_students.student_id', '=', $student[0]->id]
                ])
                ->get('classes_students.status');

            if (count($checkLearned) != 0){
                for($i = 0; $i < count($checkLearned); $i++){
                    if ($checkLearned[$i]->status == 0 ) {
                        BaseHelper::ajaxResponse('Học viên đã hoàn thành khóa học', false);
                    }elseif ($checkLearned[$i]->status == 1 ){
                        BaseHelper::ajaxResponse('Học viên đã có trong danh sách lớp học hoặc đang học lớp khác cùng khóa học', false);
                    }
                }
            }

            if ($course[0]->length >= 10){
                $fees = 500000;
            }else $fees = 480000;

            $test = DB::table('classes_students')
                ->insert([
                    'class_id'      => $requestData['class_id'],
                    'student_id'    => $student[0]->id,
                    'starttime'     => $requestData['starttime'],
                    'finishtime'    => $requestData['finishtime'],
                    'note'          => $requestData['note'],
                    'fees'          => $fees,
                    'status'        => $requestData['status'],
                    'created_by'    => Auth::id(),
                    'created_at'    => Carbon::now()
                ]);

            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        }else
            BaseHelper::ajaxResponse('Tên, ngày sinh hoặc số điện thoại trống', false);
    }

    public function viewFees(){
        return view('classes.fees');
    }

    // phần này của Study
    public function listStudy($id){
        $classes = ClassHc::findOrFail($id);
        $studies = DB::table('studies')
            ->join('lessons', 'studies.lesson_id', '=', 'lessons.id')
            ->join('teachers', 'studies.teacher', '=', 'teachers.id')
            ->where('studies.class_id', '=', $id)
            ->select('studies.id','lessons.name as lsname', 'teachers.name as tchname', 'studies.daylearn')
            ->get();
        return view('classes.listStudy', compact('classes', 'studies'));
    }

    public function getInfoStudyAjax(Request $request, $id){
        $this->checkRequestAjax($request);
        $study = Study::findOrFail($id);
        $study->daylearn = $this->changeFormatDateOutput($study->daylearn);
        BaseHelper::ajaxResponse('success', true, $study);
    }

    public function saveInfoStudyAjax(Request $request){

        $this->checkRequestAjax($request);

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            # Create new study
            $study = new Study();
            $study->created_by = Auth::id();
            $study->created_at = Carbon::now();
        }else{
            #update infomation study
            $study = Study::findOrFail($requestData['id']);
            $study->updated_by = Auth::id();
            $study->updated_at = Carbon::now();
        }
        $study->class_id    = $requestData['class_id'];
        $study->lesson_id   = $requestData['lesson_id'];
        $study->teacher     = $requestData['teacher'];
        $study->carer_staff = $requestData['carer_staff'];
        $study->coach       = $requestData['coach'];
        $study->daylearn    = $this->changeFormatDateInput($requestData['daylearn']);
        $study->location    = $requestData['location'];


        try {
            $study->save();
            BaseHelper::ajaxResponse(config('app.textSaveSuccess'), true);
        }catch (\Exception $exception){
            print_r($exception);
            die();
            BaseHelper::ajaxResponse(config('app.textSaveError'), false);
        }
    }
    //kết thúc phần của Study
}
