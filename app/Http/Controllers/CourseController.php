<?php

namespace App\Http\Controllers;

use App\Http\Plugins\BaseHelper;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function __construct()
    {

    }

    public function list()
    {
        $courses = Course::all();
        return view('course.list',compact('courses'));
    }

    public function getInfoAjax(Request $request, $id){
        $this->checkRequestAjax($request);

        $course = Course::findOrFail($id);
        BaseHelper::ajaxResponse('Success!', true, $course);
    }

    public function saveInfoAjax(Request $request ){
        $this->checkRequestAjax($request);

//        $validateData = $request->validate([
//            'name' => 'bail|required|max:255',
//            'fees' => 'bail|required',
//            'description' => 'bail|required',
//            'status' => 'bail|required'
//        ]);
//        if ($validateData == null){
//           BaseHelper::ajaxResponse('Lỗi dữ liệu',false);
//        }

        $requestData = $request->all();

        if (!isset($requestData['id']) || empty($requestData['id'])){
            #create new course
            $course = new Course();
            $course->created_by = Auth::id();
            $course->created_at = Carbon::now();
        }else{
            #update a record
            $course = Course::findOrFail($requestData['id']);
            $course->updated_by = Auth::id();
            $course->updated_at = Carbon::now();
        }
        $course->name        = $requestData['name'];
        $course->fees        = $requestData['fees'];
        $course->lenght      = $requestData['lenght'];
        $course->description = $requestData['description'];
        $course->status      = $requestData['status'];

        try {
            $course->save();
            BaseHelper::ajaxResponse('Success!', true, $course);
        }catch (\Exception $exception){
            BaseHelper::ajaxResponse('Lỗi xử lý dữ liệu', false);
        }
    }
}
