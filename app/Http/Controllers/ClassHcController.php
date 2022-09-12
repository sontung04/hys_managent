<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\ClassHc;
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
        $classes = ClassHc::findOrFail($id);
        $students = DB::table('students')
            ->join('classes_students', 'students.id', '=', 'classes_students.student_id')
            ->where('classes_students.class_id', '=', $id)
            ->orderBy('name', 'desc')
            ->select('students.*','classes_students.status')
            ->get();
        return view('classes.listStudent',compact('students','classes'));
    }

    public function viewFees(){
        return view('classes.fees');
    }
}
