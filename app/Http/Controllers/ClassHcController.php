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

    public function list(){
        $classes = ClassHc::all();
        return view('classes.list',compact('classes'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $class = ClassHc::findOrFail($id);
        BaseHelper::ajaxResponse('success', true, $class);
    }

    public function saveInfoAjax(Request $request){
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
        $class->name          = $requestData['name'];
        $class->course_id        = $requestData['course_id'];
        $class->carer_staff      = $requestData['carer_staff'];
        $class->coach           = $requestData['coach'];
        $class->status       = $requestData['status'];
        $class->starttime       = $requestData['starttime'];
        $class->finishtime       = $requestData['finishtime'];

        try {
            $class->save();
            BaseHelper::ajaxResponse('success', true);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse('Lỗi xử lý dữ liệu', false);
        }

    }

    public function listStdClass($id){
        $classes = ClassHc::findOrFail($id);
        $students = DB::table('students')
            ->join('classes_students', 'students.id', '=', 'classes_students.student_id')
            ->where('classes_students.class_id', '=', $id)
            ->select('students.*','classes_students.status')
            ->get();
        return view('classes.listStd',compact('students','classes'));
    }
}
